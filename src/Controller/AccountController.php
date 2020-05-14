<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccountController extends AbstractController
{
    public function index()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('pages/account.twig');
    }

    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $current_password = $request->get('current_password');

        $new_password = $request->get('new_password');
        $new_password_confirmation = $request->get('new_password_confirmation');

        $user = $this->getUser();

        $validated = $passwordEncoder->isPasswordValid($user, $current_password);
        $confirmed = $new_password === $new_password_confirmation;

        if (!$validated) {
            return $this->render('pages/account.twig', [
                'errors' => ['The current password is not valid.']
            ]);
        }

        if (!$confirmed) {
            return $this->render('pages/account.twig', [
                'errors' => ['The password confirmation do not match.']
            ]);
        }

        $new_password_encoded = $passwordEncoder->encodePassword($user, $new_password_confirmation);
        $user->setPassword($new_password_encoded);
        $entityManager->flush();

        return $this->render('pages/account.twig', [
            'success' => 'Your password has been successfully updated.'
        ]);
    }
}

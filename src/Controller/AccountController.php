<?php

// Déclaration de l'espace de noms de ce contrôleur.
namespace App\Controller;

// Importation des classes utilisées dans ce contrôleur.
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Déclaration de la classe AccountController qui étend AbstractController pour fournir des fonctionnalités spécifiques à l'account.
class AccountController extends AbstractController
{
    // Déclaration de la fonction index. Cette fonction est appelée lorsqu'un utilisateur accède à la page de son compte.
    public function index(): Response
    {
        // Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        // Si l'utilisateur est connecté, il est redirigé vers la page de son compte.
        return $this->render('pages/account.twig');
    }

    // Déclaration de la fonction updatePassword. Cette fonction est appelée lorsqu'un utilisateur tente de mettre à jour son mot de passe.
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Récupération du gestionnaire d'entités pour interagir avec la base de données.
        $entityManager = $this->getDoctrine()->getManager();

        // Récupération du mot de passe actuel de l'utilisateur à partir de la requête.
        $current_password = $request->get('current_password');

        // Récupération du nouveau mot de passe de l'utilisateur à partir de la requête.
        $new_password = $request->get('new_password');
        // Récupération de la confirmation du nouveau mot de passe de l'utilisateur à partir de la requête.
        $new_password_confirmation = $request->get('new_password_confirmation');

        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Vérification que le mot de passe actuel est valide.
        $validated = $passwordEncoder->isPasswordValid($user, $current_password);
        // Vérification que le nouveau mot de passe et sa confirmation sont identiques.
        $confirmed = $new_password === $new_password_confirmation;

        // Si le mot de passe actuel n'est pas valide, un message d'erreur est affiché.
        if (!$validated) {
            return $this->render('pages/account.twig', [
                'errors' => ['The current password is not valid.']
            ]);
        }

        // Si le nouveau mot de passe et sa confirmation ne sont pas identiques, un message d'erreur est affiché.
        if (!$confirmed) {
            return $this->render('pages/account.twig', [
                'errors' => ['The password confirmation do not match.']
            ]);
        }

        // Si le mot de passe actuel est valide et que le nouveau mot de passe et sa confirmation sont identiques, le mot de passe de l'utilisateur est mis à jour.
        $new_password_encoded = $passwordEncoder->encodePassword($user, $new_password_confirmation);
        $user->setPassword($new_password_encoded);
        // Les modifications sont enregistrées dans la base de données.
        $entityManager->flush();

        // Un message de succès est affiché.
        return $this->render('pages/account.twig', [
            'success' => 'Your password has been successfully updated.'
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if (in_array('ROLE_STUDENT', $user->getRoles())) {
            $repository = $this->getDoctrine()->getRepository(Lesson::class);
            $lessons = $repository->findLessonsByUser($user);

            $repository = $this->getDoctrine()->getRepository(Note::class);
            $notes = $repository->findNotesByUser($user);

            return $this->render('pages/student_home.twig', [
                'lessons' => $lessons,
                'notes' => $notes,
            ]);
        }

        return $this->render('pages/home.twig');
    }
}

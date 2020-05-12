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

        // If the authenticated user is a teacher or a student,
        // then render particular views
        if (in_array('ROLE_TEACHER', $user->getRoles()) || in_array('ROLE_STUDENT', $user->getRoles())) {

            // We need lessons for both teacher and student
            $repository = $this->getDoctrine()->getRepository(Lesson::class);
            $lessons = $repository->findLessonsByUser($user);

            if (in_array('ROLE_TEACHER', $user->getRoles())) {
                return $this->render('pages/teacher_home.twig', [
                    'lessons' => $lessons
                ]);
            }

            if (in_array('ROLE_STUDENT', $user->getRoles())) {
                $repository = $this->getDoctrine()->getRepository(Note::class);
                $notes = $repository->findNotesByUser($user);

                return $this->render('pages/student_home.twig', [
                    'lessons' => $lessons,
                    'notes' => $notes,
                ]);
            }
        }

        return $this->render('pages/home.twig');
    }
}

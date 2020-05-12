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

            if (in_array('ROLE_TEACHER', $user->getRoles())) {
                $repository = $this->getDoctrine()->getRepository(Lesson::class);
                $lessons = $repository->findLessonsByTeacherFromDate($user, new \DateTime());

                return $this->render('pages/teacher_home.twig', [
                    'lessons' => $lessons
                ]);
            }

            if (in_array('ROLE_STUDENT', $user->getRoles())) {
                $repository = $this->getDoctrine()->getRepository(Lesson::class);
                $lessons = $repository->findLessonsByGradeFromDate($user->getGrade(), new \DateTime());

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

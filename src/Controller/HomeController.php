<?php

// Déclaration de l'espace de noms de ce contrôleur.
namespace App\Controller;

// Importation des classes utilisées dans ce contrôleur.
use App\Entity\Lesson;
use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Déclaration de la classe HomeController qui étend AbstractController pour fournir des fonctionnalités spécifiques à l'account.
class HomeController extends AbstractController
{
    // Déclaration de la fonction index. Cette fonction est appelée lorsqu'un utilisateur accède à la page d'accueil.
    public function index()
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        // Si l'utilisateur a le rôle 'ROLE_TEACHER', on récupère ses leçons et on affiche la page d'accueil de l'enseignant.
        if (in_array('ROLE_TEACHER', $user->getRoles())) {
            // Récupération du dépôt de l'entité Lesson.
            $repository = $this->getDoctrine()->getRepository(Lesson::class);
            // Récupération des leçons de l'enseignant à partir de la date actuelle.
            $lessons = $repository->findLessonsByTeacherFromDate($user, new \DateTime());

            // Affichage de la page d'accueil de l'enseignant avec les leçons en paramètre.
            return $this->render('pages/teacher_home.twig', [
                'lessons' => $lessons
            ]);
        }

        // Si l'utilisateur a le rôle 'ROLE_STUDENT', on récupère ses leçons et ses notes et on affiche la page d'accueil de l'étudiant.
        if (in_array('ROLE_STUDENT', $user->getRoles())) {
            // Récupération du dépôt de l'entité Lesson.
            $repository = $this->getDoctrine()->getRepository(Lesson::class);
            // Récupération des leçons de la classe de l'étudiant à partir de la date actuelle.
            $lessons = $repository->findLessonsByGradeFromDate($user->getGrade(), new \DateTime());

            // Récupération du dépôt de l'entité Note.
            $repository = $this->getDoctrine()->getRepository(Note::class);
            // Récupération des 3 dernières notes de l'utilisateur.
            $notes = $repository->findNotesByUser($user, 3);

            // Affichage de la page d'accueil de l'étudiant avec les leçons et les notes en paramètre.
            return $this->render('pages/student_home.twig', [
                'lessons' => $lessons,
                'notes' => $notes,
            ]);
        }

        // Si l'utilisateur n'a ni le rôle 'ROLE_TEACHER' ni le rôle 'ROLE_STUDENT', on affiche la page d'accueil générique.
        return $this->render('pages/home.twig');
    }
}

<?php

// Déclaration de l'espace de noms de ce contrôleur.
namespace App\Controller;

// Importation des classes utilisées dans ce contrôleur.
use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Déclaration de la classe NoteController qui étend AbstractController pour fournir des fonctionnalités spécifiques à la gestion des notes.
class NoteController extends AbstractController
{
    // Déclaration de la fonction index. Cette fonction est appelée lorsqu'un utilisateur accède à la page d'accueil des notes.
    public function index(NoteRepository $noteRepository): Response
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur est un enseignant, on récupère toutes les notes et on affiche la page d'accueil des notes.
        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {
            return $this->render('notes/index.html.twig', [
                'notes' => $noteRepository->findAll(),
            ]);
        }

        // Si l'utilisateur est un étudiant, on récupère ses notes et on affiche la page de ses notes.
        if (in_array('ROLE_STUDENT', $user->getRoles())) {
            $repository = $this->getDoctrine()->getRepository(Note::class);
            $notes = $repository->findNotesByUser($user);

            return $this->render('pages/student_note.twig', [
                'notes' => $notes,
            ]);
        }

        // Si l'utilisateur n'est ni un enseignant ni un étudiant, on le redirige vers la page d'accueil.
        return $this->redirectToRoute('index');
    }

    // Déclaration de la fonction new. Cette fonction est appelée lorsqu'un enseignant tente de créer une nouvelle note.
    public function new(Request $request): Response
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur est un enseignant, on crée une nouvelle note et on affiche le formulaire de création de note.
        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {
            $note = new Note();
            $form = $this->createForm(NoteType::class, $note);
            $form->handleRequest($request);

            // Si le formulaire est soumis et valide, on enregistre la nouvelle note dans la base de données et on redirige l'enseignant vers la page d'accueil des notes.
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($note);
                $entityManager->flush();

                return $this->redirectToRoute('notes_index');
            }

            // Si le formulaire n'est pas encore soumis ou n'est pas valide, on affiche le formulaire de création de note.
            return $this->render('notes/new.html.twig', [
                'note' => $note,
                'form' => $form->createView(),
            ]);
        }

        // Si l'utilisateur n'est pas un enseignant, on le redirige vers la page d'accueil.
        return $this->redirectToRoute('index');
    }

    // Déclaration de la fonction show. Cette fonction est appelée lorsqu'un enseignant tente de voir une note spécifique.
    public function show(Note $note): Response
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur est un enseignant, on affiche la note spécifiée.
        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {
            return $this->render('notes/show.html.twig', [
                'note' => $note,
            ]);
        }

        // Si l'utilisateur n'est pas un enseignant, on le redirige vers la page d'accueil.
        return $this->redirectToRoute('index');
    }

    // Déclaration de la fonction edit. Cette fonction est appelée lorsqu'un enseignant tente de modifier une note spécifique.
    public function edit(Request $request, Note $note): Response
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur est un enseignant, on affiche le formulaire de modification de la note spécifiée.
        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {
            $form = $this->createForm(NoteType::class, $note);
            $form->handleRequest($request);

            // Si le formulaire est soumis et valide, on enregistre les modifications dans la base de données et on redirige l'enseignant vers la page d'accueil des notes.
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('notes_index');
            }

            // Si le formulaire n'est pas encore soumis ou n'est pas valide, on affiche le formulaire de modification de note.
            return $this->render('notes/edit.html.twig', [
                'note' => $note,
                'form' => $form->createView(),
            ]);
        }

        // Si l'utilisateur n'est pas un enseignant, on le redirige vers la page d'accueil.
        return $this->redirectToRoute('index');
    }

    // Déclaration de la fonction delete. Cette fonction est appelée lorsqu'un enseignant tente de supprimer une note spécifique.
    public function delete(Request $request, Note $note): Response
    {
        // Récupération de l'utilisateur actuellement connecté.
        $user = $this->getUser();

        // Si l'utilisateur est un enseignant et que le jeton CSRF est valide, on supprime la note spécifiée de la base de données et on redirige l'enseignant vers la page d'accueil des notes.
        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {
            if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($note);
                $entityManager->flush();
            }

            return $this->redirectToRoute('notes_index');
        }

        // Si l'utilisateur n'est pas un enseignant, on le redirige vers la page d'accueil.
        return $this->redirectToRoute('index');
    }
}

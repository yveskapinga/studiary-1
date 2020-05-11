<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response
    {
        $user = $this->getUser();

        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {

            return $this->render('note/index.html.twig', [
                'notes' => $noteRepository->findAll(),
            ]);
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/new", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $user = $this->getUser();

        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {

            $note = new Note();
            $form = $this->createForm(NoteType::class, $note);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($note);
                $entityManager->flush();

                return $this->redirectToRoute('note_index');
            }

            return $this->render('note/new.html.twig', [
                'note' => $note,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{id}", name="note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        $user = $this->getUser();

        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {

            return $this->render('note/show.html.twig', [
                'note' => $note,
            ]);
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {

        $user = $this->getUser();

        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {

            $form = $this->createForm(NoteType::class, $note);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('note_index');
            }

            return $this->render('note/edit.html.twig', [
                'note' => $note,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response
    {
        
        $user = $this->getUser();

        if ($user && in_array('ROLE_TEACHER', $user->getRoles())) {

            if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($note);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('note_index');
        }

        return $this->redirectToRoute('index');
    }
}

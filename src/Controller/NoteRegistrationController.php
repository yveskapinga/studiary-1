<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NoteRegistrationController extends AbstractController
{
    /**
     * @Route("/addnote", name="noteRegistration")
     */
    public function index()
    {
        return $this->render('addnote.html.twig', [
            'controller_name' => 'NoteRegistrationController'
        ]);
    }
}

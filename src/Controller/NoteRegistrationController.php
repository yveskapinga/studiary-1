<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteRegistrationController extends AbstractController
{
    public function index()
    {
        return $this->render('addnote.html.twig', [
            'controller_name' => 'NoteRegistrationController'
        ]);
    }
}

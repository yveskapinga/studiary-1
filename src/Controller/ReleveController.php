<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReleveController extends AbstractController
{
    public function index()
    {
        return $this->render('releve.html.twig', [
            'controller_name' => 'ReleveController'
        ]);
    }
}

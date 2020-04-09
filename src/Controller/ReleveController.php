<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/releve", name="releve")
     */
    public function index()
    {
        return $this->render('releve.html.twig', [
            'controller_name' => 'ReleveController'
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    public function index()
    {
        return $this->render('calendar.html.twig', [
            'controller_name' => 'CalendarController'
        ]);
    }
}

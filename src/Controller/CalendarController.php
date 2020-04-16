<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Lesson;
use Doctrine\ORM\EntityRepository;

class CalendarController extends AbstractController
{
    public function index()
    {
        return $this->render('calendar.html.twig', [
            'controller_name' => 'CalendarController'
        ]);
    }

    public function getAllLessons()
    {

        return $this->render('calendar.html.twig', [
            'controller_name' => 'CalendarController'
        ]);
    }
}

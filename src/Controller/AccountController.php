<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    public function index()
    {
        return $this->render('pages/account.twig');
    }
}
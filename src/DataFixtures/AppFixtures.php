<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Subject;
use App\Entity\Grade;
use App\Entity\Lesson;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Generate User (2 teachers  + 8 students)
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('test'.$i.'@test.com');
            $user->setFirstName('Prenom'.$i);
            $user->setLastName('Nom'.$i);
            $user->setPassword('test');
            if($i == 2 || $i == 4){
                $user->setRoles(["ROLE_TEACHER"]);
            }
            $manager->persist($user);
        }

        // Generate Subject (5)
        for ($i = 0; $i < 5; $i++) {
            $subject = new Subject();
            $subject->setName("Matieres".$i);
            $manager->persist($subject);
        }
        
        // Generate Grade (5)
        for ($i = 0; $i < 5; $i++) {
            $grade = new Grade();
            $grade->setName("Classe n°".$i);
            $manager->persist($grade);
        }

        // Generate Lesson (5)
        for ($i = 1; $i < 6; $i++) {
            $lesson = new Lesson();
            $lesson->setName("Lesson n°".$i);
            $lesson->setStartDate(new \DateTime('0'.$i.'/06/2020'));
            $lesson->setEndDate(new \DateTime('0'.$i.'/06/2020'));

            $lesson->setStartTime(new \DateTime('1'.$i.':00'));
            $lesson->setEndTime(new \DateTime('1'.($i+1).':00'));

            $manager->persist($lesson);
        }



        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        // for ($i = 0; $i < 20; $i++) {
        //     $lesson = new Lesson();
        //     $lesson->setName('product '.$i);
        //     $lesson->setPrice(mt_rand(10, 100));
        //     $manager->persist($lesson);
        // }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures\Entity;

use App\Entity\Episode;
use App\Entity\Studio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StudioFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $manager->flush();
    }
}

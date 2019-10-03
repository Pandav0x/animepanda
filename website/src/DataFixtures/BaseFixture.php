<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->loadData($manager);
    }

    abstract protected function loadData(ObjectManager $manager);
}
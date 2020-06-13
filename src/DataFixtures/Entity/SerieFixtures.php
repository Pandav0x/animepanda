<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\BaseFixture;
use App\Entity\Serie;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SerieFixtures extends BaseFixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany($this->faker->numberBetween(50, 80), 'serie', function(){
            $serie = new Serie();
            return $serie->setSynopsis($this->faker->text);
        });

        $manager->flush();
    }
}

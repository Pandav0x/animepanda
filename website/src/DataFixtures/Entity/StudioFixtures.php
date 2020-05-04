<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\BaseFixture;
use App\Entity\Studio;
use Doctrine\Common\Persistence\ObjectManager;

class StudioFixtures extends BaseFixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany($this->faker->numberBetween(10, 15), 'studio', function(){
            $studio = new Studio();
            return $studio->setName($this->faker->name)
                ->setWebsite($this->faker->url);
        });

        $manager->flush();
    }
}

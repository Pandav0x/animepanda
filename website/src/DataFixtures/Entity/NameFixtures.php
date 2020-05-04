<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\BaseFixture;
use App\Entity\Name;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class NameFixtures extends BaseFixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    protected function loadData(ObjectManager $manager): void
    {
        foreach($this->getReferenceGenerator('serie') as $serie){
            $name = new Name();
            $name->setText($this->faker->word)
                ->setIsDefault(true)
                ->setSerie($serie);
            $manager->persist($name);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SerieFixtures::class
        ];
    }
}

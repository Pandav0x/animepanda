<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\BaseFixture;
use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends BaseFixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'tag', function(){
            $tag = new Tag();
            return $tag->setName($this->faker->word);
        });

        $manager->flush();
    }
}

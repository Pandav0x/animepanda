<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;


use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class BaseFixture
 *
 * @package App\DataFixtures
 */
abstract class BaseFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var array
     */
    private $referencesIndex = [];

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    abstract protected function loadData(ObjectManager $manager);

    /**
     * TODO: changer ObjectManager(deprecated) par EntityManagerInterface
     *
     * @param ObjectManager $manager
     */
    public function load(\Doctrine\Persistence\ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');

        $this->loadData($manager);
    }

    /**
     * @param int      $count
     * @param string   $groupName
     * @param callable $factory
     */
    protected function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = $factory($i);

            if (null === $entity) {
                throw new \LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }

            $this->manager->persist($entity);

            // store for usage later as groupName_#COUNT#
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    /**
     * @param string $groupName
     * @return object
     */
    protected function getRandomReference(string $groupName)
    {
        if (!isset($this->referencesIndex[$groupName])) {
            $this->referencesIndex[$groupName] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $groupName . '_') === 0) {
                    $this->referencesIndex[$groupName][] = $key;
                }
            }
        }

        if (empty($this->referencesIndex[$groupName])) {
            throw new \InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"',
              $groupName));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$groupName]);

        return $this->getReference($randomReferenceKey);
    }

    /**
     * @param string $className
     * @param int    $count
     * @return array
     */
    protected function getRandomReferences(string $className, int $count): array
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($className);
        }

        return $references;
    }

    /**
     * @param string $groupName
     * @return object
     */
    protected function getReferenceGenerator(string $groupName)
    {
        if (!isset($this->referencesIndex[$groupName])) {
            $this->referencesIndex[$groupName] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $groupName . '_') === 0) {
                    $this->referencesIndex[$groupName][] = $key;
                }
            }
        }

        if (empty($this->referencesIndex[$groupName])) {
            throw new \InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"',
              $groupName));
        }

        foreach ($this->referencesIndex[$groupName] as $referenceIndex) {
            yield $this->getReference($referenceIndex);
        }
    }
}
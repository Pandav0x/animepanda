<?php

namespace App\Tests\Command;

use App\Entity\Episode;
use App\Entity\Name;
use App\Entity\Serie;
use App\Entity\Studio;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class InstallationCommandTest
 * @package App\Tests\Command
 */
class InstallationCommandTest extends KernelTestCase
{
    private $entityManager;

    private $episodeRepository;
    private $nameRepository;
    private $serieRepository;
    private $studioRepository;
    private $tagRepository;

    private $commandTester;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $application = new Application($kernel);

        $command = $application->find('application:install');
        $this->commandTester = new CommandTester($command);

        $this->episodeRepository = $this->entityManager->getRepository(Episode::class);

        $this->nameRepository = $this->entityManager->getRepository(Name::class);

        $this->serieRepository = $this->entityManager->getRepository(Serie::class);

        $this->studioRepository = $this->entityManager->getRepository(Studio::class);

        $this->tagRepository = $this->entityManager->getRepository(Tag::class);
    }

    protected function tearDown()
    {
        $this->entityManager = null;

        $this->commandTester = null;

        $this->episodeRepository = null;

        $this->nameRepository = null;

        $this->serieRepository = null;

        $this->studioRepository = null;

        $this->tagRepository = null;
    }

    public function testInstallationCommandNoOption()
    {
        $this->commandTester->execute([]);

        $commandDisplay = trim($this->commandTester->getDisplay());

        $this->assertContains('doctrine:database:drop --force', $commandDisplay);
        $this->assertContains('doctrine:database:create', $commandDisplay);
        $this->assertContains('doctrine:migration:migrate -q', $commandDisplay);
        $this->assertContains('[OK]', $commandDisplay);
    }

    public function testInstallationCommandDatasetOption()
    {
        $this->commandTester->execute(['--dataset' => true]);

        $commandDisplay = trim($this->commandTester->getDisplay());

        $this->assertContains('Inserting data', $commandDisplay);
        $this->assertContains('[OK]', $commandDisplay);

        $this->assertGreaterThanOrEqual(1, $this->episodeRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->nameRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->serieRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->studioRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->tagRepository->count([]));
    }

    public function testInstallationCommandComposerOption()
    {
        $this->commandTester->execute(['--composer' => true]);

        $commandDisplay = trim($this->commandTester->getDisplay());

        $this->assertContains('composer install', $commandDisplay);
        $this->assertContains('[OK]', $commandDisplay);
    }

    public function testInstallationCommandYarnOption()
    {
        $this->commandTester->execute(['--yarn' => true]);

        $commandDisplay = trim($this->commandTester->getDisplay());

        $this->assertContains('yarn', $commandDisplay);
        $this->assertContains('[OK]', $commandDisplay);
    }

    public function testInstallationCommandAllOptions()
    {
        $this->commandTester->execute([
            '--dataset' => true,
            '--composer' => true,
            '--yarn' => true
        ]);

        $commandDisplay = trim($this->commandTester->getDisplay());

        $this->assertContains('doctrine:database:drop --force', $commandDisplay);
        $this->assertContains('doctrine:database:create', $commandDisplay);
        $this->assertContains('doctrine:migration:migrate -q', $commandDisplay);
        $this->assertContains('composer install', $commandDisplay);
        $this->assertContains('yarn', $commandDisplay);
        $this->assertContains('Inserting data', $commandDisplay);
        $this->assertContains('[OK]', $commandDisplay);

        $this->assertGreaterThanOrEqual(1, $this->episodeRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->nameRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->serieRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->studioRepository->count([]));
        $this->assertGreaterThanOrEqual(1, $this->tagRepository->count([]));
    }
}
<?php

namespace App\Tests\Command;

use App\Command\InstallationCommand;
use App\Repository\EpisodeRepository;
use App\Repository\NameRepository;
use App\Repository\SerieRepository;
use App\Repository\StudioRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class InstallationCommandTest
 * @package App\Tests\Command
 */
class InstallationCommandTest extends TestCase
{

    private $entityManagerInterfaceMock;
    private $episodeRepositoryMock;
    private $nameRepositoryMock;
    private $serieRepositoryMock;
    private $studioRepositoryMock;
    private $tagRepositoryMock;

    private $commandTester;

    protected function setUp()
    {
        $this->entityManagerInterfaceMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->episodeRepositoryMock = $this->getMockBuilder(EpisodeRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->nameRepositoryMock = $this->getMockBuilder(NameRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serieRepositoryMock = $this->getMockBuilder(SerieRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->studioRepositoryMock = $this->getMockBuilder(StudioRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tagRepositoryMock = $this->getMockBuilder(TagRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new InstallationCommand(
            $this->entityManagerInterfaceMock,
            $this->episodeRepositoryMock,
            $this->nameRepositoryMock,
            $this->serieRepositoryMock,
            $this->studioRepositoryMock,
            $this->tagRepositoryMock
        ));
        $command = $application->find('application:install');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown()
    {
        $this->entityManagerInterfaceMock = null;

        $this->episodeRepositoryMock = null;

        $this->nameRepositoryMock = null;

        $this->serieRepositoryMock = null;

        $this->studioRepositoryMock = null;

        $this->tagRepositoryMock = null;
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
    }
}
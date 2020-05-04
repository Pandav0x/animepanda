<?php


namespace App\Command\Tracking;


use App\Repository\TrackingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TrackingPurgeCommand extends Command
{
    protected static $defaultName = 'application:tracking:purge';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TrackingRepository */
    private $trackingRepository;

    /**
     * TrackingPurgeCommand constructor.
     * @param string|null $name
     * @param EntityManagerInterface $entityManager
     * @param TrackingRepository $trackingRepository
     */
    public function __construct(?string $name = null, EntityManagerInterface $entityManager, TrackingRepository $trackingRepository)
    {
        parent::__construct($name);

        $this->entityManager = $entityManager;
        $this->trackingRepository = $trackingRepository;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Purging tracking data');

        $io->write(str_pad('purging...', 15));

        $trackings = $this->trackingRepository->findAll();
        foreach ($trackings as $tracking){
            $this->entityManager->remove($tracking);
        }

        $io->writeln('<fg=green>[OK]</>');

        return 0;
    }
}
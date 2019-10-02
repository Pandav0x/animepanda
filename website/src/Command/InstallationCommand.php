<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EpisodeRepository;
use App\Repository\NameRepository;
use App\Repository\SerieRepository;
use App\Repository\StudioRepository;
use App\Repository\TagRepository;
use App\Entity\Episode;
use App\Entity\Name;
use App\Entity\Serie;
use App\Entity\Studio;
use App\Entity\Tag;

/**
 * Class InstallationCommand
 * @package App\Command
 */
class InstallationCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = "application:install";

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EpisodeRepository
     */
    private $episodeRepository;

    /**
     * @var NameRepository
     *
     */
    private $nameRepository;

    /**
     * @var SerieRepository
     *
     */
    private $serieRepository;

    /**
     * @var StudioRepository
     *
     */
    private $studioRepository;

    /**
     * @var TagRepository
     *
     */
    private $tagRepository;

    /**
     * InstallationCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param EpisodeRepository $episodeRepository
     * @param NameRepository $nameRepository
     * @param SerieRepository $serieRepository
     * @param StudioRepository $studioRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EpisodeRepository $episodeRepository,
        NameRepository $nameRepository,
        SerieRepository $serieRepository,
        StudioRepository $studioRepository,
        TagRepository $tagRepository
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->episodeRepository = $episodeRepository;
        $this->nameRepository = $nameRepository;
        $this->serieRepository = $serieRepository;
        $this->studioRepository = $studioRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this->setDescription("Install project with samples insertions in database.")
            ->addOption(
                "dataset",
                "d",
                InputOption::VALUE_NONE,
                "Insert default values in DB."
            )
            ->addOption(
                "composer",
                "c",
                InputOption::VALUE_NONE,
                "Install and update composer dependancies."
            )
            ->addOption(
                "yarn",
                "y",
                InputOption::VALUE_NONE,
                "Install the node.js libraries for the front end."
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hasDataset = $input->getOption("dataset");
        $hasComposer = $input->getOption("composer");
        $hasYarn = $input->getOption("yarn");

        $io = new SymfonyStyle($input, $output);

        $io->title("Installing project for [". $_ENV["APP_ENV"] . "]");

        preg_match('/([0-9]{1,3}\.){3}[0-9]{1,3}/', $_ENV['DATABASE_URL'], $matches);
        $dbIP = array_shift($matches);
        preg_match('/(?<=\:)[0-9]{1,4}/', $_ENV['DATABASE_URL'], $matches);
        $dbPort = array_shift($matches);

        $isDatabaseOn = is_resource(@fsockopen($dbIP, $dbPort));

        if(!$isDatabaseOn)
        {
            $io->note('No database connection detected. All interactions are disabled.');
        }

        $env = ($_ENV["APP_ENV"] == "prod") ? "build" : "dev";

        if($hasComposer)
        {
            $options = "-q " . (($env == "dev")? "--dev" : "--no-dev -o");
            $io->write(str_pad("composer install " . $options, 40));
            Process::fromShellCommandline("composer install " . $options)->run();
            $io->writeln("<fg=green>[OK]</>");
        }

        if($hasYarn)
        {
            $io->write(str_pad("yarn " . $env . " --silent", 40));
            Process::fromShellCommandline("yarn " . $env . " --silent")->run();
            $io->writeln("<fg=green>[OK]</>");
        }

        if($isDatabaseOn)
        {
            $io->write(str_pad("doctrine:database:drop --force", 40));
            Process::fromShellCommandline("php bin/console doctrine:database:drop --force")->run();
            $io->writeln("<fg=green>[OK]</>");
            $io->write(str_pad("doctrine:database:create", 40));
            Process::fromShellCommandline("php bin/console doctrine:database:create")->run();
            $io->writeln("<fg=green>[OK]</>");
            $io->write(str_pad("doctrine:migration:migrate -q", 40));
            Process::fromShellCommandline("php bin/console doctrine:migration:migrate -q")->run();
            $io->writeln("<fg=green>[OK]</>");

            if ($hasDataset) {

                $io->write(str_pad("Inserting data", 40));

                $tagsContent = [
                    "Adventure" => "Adventure description",
                    "Comedy" => "Comedy description",
                    "Martial Art" => "Martial art description",
                    "Shonen" => "Shonen description"
                ];

                $namesText = [
                    "This is a sample text",
                    "Exemple de texte",
                    "これはサンプルテキストです"
                ];

                $episodes = [
                    "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4",
                    "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_2mb.mp4",
                    "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_5mb.mp4",
                    "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_10mb.mp4"
                ];

                $thumbnailImages = [
                    "https://images.unsplash.com/photo-1524419986249-348e8fa6ad4a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80",
                    "https://images.unsplash.com/photo-1446292267125-fecb4ecbf1a5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80",
                    "https://images.unsplash.com/photo-1525534240745-6b6f65e8a25f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1190&q=80",
                    "https://images.unsplash.com/photo-1558384697-9f60d34dd204?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80"
                ];

                $thumbnailVideos = [
                    "https://media2.giphy.com/media/4QxQgWZHbeYwM/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp",
                    "https://media0.giphy.com/media/mlBDoVLOGidEc/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp",
                    "https://media1.giphy.com/media/ErZ8hv5eO92JW/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp",
                    "https://media2.giphy.com/media/Id0IZ49MNMzKHI9qpV/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp"
                ];

                $studio = new Studio();
                $studio->setName("Sample Studio");
                $studio->setWebsite("http://google.com");

                $serie = new Serie();

                $tags = [];
                foreach($tagsContent as $tagName => $description)
                {
                    $tag = new Tag();
                    $tag->setName($tagName);
                    $tag->setDescription($description);
                    $tags[] = $tag;
                }

                $serieNames = [];
                foreach ($namesText as $name) {
                    $serieName = new Name();
                    $serieName->setText($name);
                    $serieName->setIsDefault(count($serieNames) == 0);
                    $serieNames[] = $serieName;
                    $serie->addName($serieName);
                }

                $serie->setSynopsis("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic eum ut vitae quos perspiciatis fugiat laborum accusamus. Optio iusto perferendis ut, voluptatum deserunt voluptatem quo. Nam odio dolorum earum iure?");

                for($i=0; $i < count($episodes); $i++) {
                    $episode = new Episode();
                    $episode->setUrl($episodes[$i]);
                    $episode->setNumber($i);
                    $episode->setReleaseDate(new \DateTimeImmutable());
                    $episode->setStudio($studio);
                    $episode->setThumbnailImage($thumbnailImages[$i]);
                    $episode->setThumbnailVideo($thumbnailVideos[$i]);
                    $episode->setViews(0);
                    $episode->addTag($tags[$i%count($tags)]);
                    $episode->setStudio($studio);
                    $serie->addEpisode($episode);
                }

                $this->entityManager->persist($serie);
                $this->entityManager->flush();

                $io->writeln("<fg=green>[OK]</>");
            }
        }
        $io->success('Installation complete.');
    }
}
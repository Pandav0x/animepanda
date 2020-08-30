<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Factory\Widget\ItemListAdapter;
use App\Repository\ContactRepository;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Form\DTO\ContactHandler;

class MainController extends AbstractController
{
    /** @var ItemListAdapter */
    private $itemListAdapter;

    /** @var EpisodeRepository */
    private $episodeRepository;

    public function __construct(EpisodeRepository $episodeRepository, ItemListAdapter $itemListAdapter)
    {
        $this->episodeRepository = $episodeRepository;
        $this->itemListAdapter = $itemListAdapter;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function homepage(Request $request): Response
    {
        return $this->render('pages/index.html.twig', [
          'lastEpisodes' => $this->itemListAdapter->createItemListFromEpisodes($this->episodeRepository->getLast()),
          'recentEpisodes' => $this->itemListAdapter->createItemListFromEpisodes($this->episodeRepository->getMostRecent())
        ]);
    }
}

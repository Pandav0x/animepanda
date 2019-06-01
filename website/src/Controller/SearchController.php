<?php

namespace App\Controller;

use App\Repository\TagRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/tags", name="search_tags", methods={"POST"})
     * @ParamConverter("post")
     */
    public function searchTags(Request $request, TagRepository $tagRepo): Response
    {
        $tagIds = explode(',', $request->request->get("tags"));

        $tags = $tagRepo->findById($tagIds);

        return $this->render('search/tags.html.twig', [
            "tags" => $tags
        ]);
    }

    /**
     * @Route("/episodes", name="search_series", methods={"POST"})
     * @ParamConverter("post")
     */
    public function searchSerie(Request $request, SerieRepository $serieRepo): Response
    {
        $words = $request->request->get("search");

        $episodes = [];
        foreach($serieRepo->findByNameContains($words) as $serie)
            foreach($serie->getEpisodes() as $episode)
            $episodes[] = $episode;

        return $this->render('episode/index.html.twig', [
            "episodes" => $episodes,
            "search" => $words
        ]);
    }
}

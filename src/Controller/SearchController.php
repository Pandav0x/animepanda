<?php

namespace App\Controller;

use App\Repository\TagRepository;
use App\Repository\NameRepository;
use App\Repository\SerieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/tags", name="search_tags", methods={"POST"})
     * @ParamConverter("post")
     * @param Request $request
     * @param TagRepository $tagRepo
     * @return Response
     */
    public function searchTags(Request $request, TagRepository $tagRepo): Response
    {
        $tagIds = explode(',', $request->request->get('tags'));

        $tags = $tagRepo->findById($tagIds);

        return $this->render('search/tags.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/episodes", name="search_series", methods={"POST"})
     * @ParamConverter("post")
     * @param Request $request
     * @param NameRepository $nameRepo
     * @return Response
     */
    public function searchSerie(Request $request, NameRepository $nameRepo): Response
    {
        $words = $request->request->get('search');

        $episodes = [];
        foreach($nameRepo->findByTextContains($words) as $name)
        {
            foreach($name->getSerie()->getEpisodes() as $episode)
            {
                $episodes[] = $episode;
            }    
        }

        return $this->render('episode/index.html.twig', [
            'episodes' => $episodes,
            'search' => $words
        ]);
    }
}

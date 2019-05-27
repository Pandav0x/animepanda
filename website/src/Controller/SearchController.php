<?php

namespace App\Controller;

use App\Repository\TagRepository;
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
    public function search(Request $request): Response
    {
        $tags = explode(',', $request->request->get("tags"));
        
        return $this->render('search/tags.html.twig', [
            "tags" => $tags
        ]);
    }
}
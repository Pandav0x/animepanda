<?php


namespace App\Factory\Widget;


use App\DTO\Widget\ItemListDTO;
use App\Entity\Episode;
use App\Entity\Serie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ItemListAdapter
{
    /** @var UrlGeneratorInterface */
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function createItemListFromEpisode(Episode $episode): ItemListDTO
    {
        return new ItemListDTO(
            $episode->getSerie()->getDefaultName(),
            $this->router->generate('episode_show', ['id' => $episode->getId()]),
            $episode->getThumbnailImage(),
            $episode->getThumbnailVideo(),
            $episode->getViews() . ' views'
        );
    }

    public function createItemListFromSerie(Serie $serie): ItemListDTO
    {
        return new ItemListDTO(
            $serie->getDefaultName(),
            $this->router->generate('serie_show', ['id' => $serie->getId()]),
            $serie->getCoverImage(),
            null,
            $serie->getEpisodes()->count() . ' episodes'
        );
    }
    public function createItemListFromEpisodes(array $episodes): array
    {
        $formattedList = [];

        /** @var Episode $episode */
        foreach ($episodes as $episode)
        {
            $formattedList[] = $this->createItemListFromEpisode($episode);
        }

        return $formattedList;
    }

    public function createItemListFromSeries(array $series): array
    {
        $formattedList = [];

        /** @var Serie $serie */
        foreach($series as $serie)
        {
            $formattedList[] = $this->createItemListFromSerie($serie);
        }

        return $formattedList;
    }
}
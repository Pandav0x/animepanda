<?php

namespace App\DataFixtures\Entity;

use App\DataFixtures\BaseFixture;
use App\Entity\Episode;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EpisodeFixtures extends BaseFixture implements DependentFixtureInterface
{

    private $episodeURLs = [
        'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
        'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_2mb.mp4',
        'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_5mb.mp4',
        'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_10mb.mp4'
    ];


    private $thumbnailImagesURLs = [
        'https://images.unsplash.com/photo-1524419986249-348e8fa6ad4a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80',
        'https://images.unsplash.com/photo-1446292267125-fecb4ecbf1a5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80',
        'https://images.unsplash.com/photo-1525534240745-6b6f65e8a25f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1190&q=80',
        'https://images.unsplash.com/photo-1558384697-9f60d34dd204?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80'
    ];

    private $thumbnailVideosURLs = [
        'https://media2.giphy.com/media/4QxQgWZHbeYwM/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp',
        'https://media0.giphy.com/media/mlBDoVLOGidEc/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp',
        'https://media1.giphy.com/media/ErZ8hv5eO92JW/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp',
        'https://media2.giphy.com/media/Id0IZ49MNMzKHI9qpV/200w.webp?cid=790b76115d3a29264a4a50306f602b9b&rid=200w.webp'
    ];

    /**
     * @param ObjectManager $manager
     * @return mixed|void
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany($this->faker->numberBetween(100, 200), 'episode', function(){
            $episode = new Episode();
            $episode->setUrl($this->faker->randomElement($this->episodeURLs))
                ->setThumbnailImage($this->faker->randomElement($this->thumbnailImagesURLs))
                ->setThumbnailVideo($this->faker->randomElement($this->thumbnailVideosURLs))
                ->setReleaseDate(new DateTimeImmutable($this->faker->dateTimeInInterval()->format('Y-m-d')))
                ->setSerie($this->getRandomReference('serie'))
                ->setStudio($this->getRandomReference('studio'))
                ->setNumber($this->faker->randomNumber(5))
                ->setViews($this->faker->numberBetween(0, 5000));

            $tags = $this->getRandomReferences('tag', $this->faker->numberBetween(2, 10));

            foreach ($tags as $tag){
                $episode->addTag($tag);
            }

            return $episode;

        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SerieFixtures::class,
            StudioFixtures::class,
            TagFixtures::class
        ];
    }
}

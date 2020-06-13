<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EpisodeRepository")
 */
class Episode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serie", inversedBy="episodes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="episodes", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $releaseDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Studio", inversedBy="episodes", cascade={"persist"})
     */
    private $studio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnailImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnailVideo;

    /**
     * Episode constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Episode
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Episode
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Serie|null
     */
    public function getSerie(): Serie
    {
        return $this->serie;
    }

    /**
     * @param Serie|null $serie
     * @return Episode
     */
    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     * @return Episode
     */
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * @param Tag $tag
     * @return Episode
     */
    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {

        return $this->getSerie()->getName()." ".$this->getNumber();

    }

    /**
     * @return int|null
     */
    public function getViews(): ?int
    {
        return $this->views;
    }

    /**
     * @param int $views
     * @return Episode
     */
    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTimeImmutable $releaseDate
     * @return Episode
     */
    public function setReleaseDate(\DateTimeImmutable $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Studio|null
     */
    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    /**
     * @param Studio|null $studio
     * @return Episode
     */
    public function setStudio(?Studio $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnailImage(): ?string
    {
        return $this->thumbnailImage;
    }

    /**
     * @param string $thumbnailImage
     * @return Episode
     */
    public function setThumbnailImage(string $thumbnailImage): self
    {
        $this->thumbnailImage = $thumbnailImage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnailVideo(): ?string
    {
        return $this->thumbnailVideo;
    }

    /**
     * @param string $thumbnailVideo
     * @return Episode
     */
    public function setThumbnailVideo(string $thumbnailVideo): self
    {
        $this->thumbnailVideo = $thumbnailVideo;

        return $this;
    }
}

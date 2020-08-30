<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="serie", orphanRemoval=true, cascade={"persist"})
     */
    private $episodes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Name", mappedBy="serie", orphanRemoval=true, cascade={"persist"})
     */
    private $names;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * Serie constructor.
     */
    public function __construct()
    {
        $this->episodes = new ArrayCollection();
        $this->names = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setSerie($this);
        }

        return $this;
    }

    /**
     * @param Episode $episode
     * @return Serie
     */
    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            if ($episode->getSerie() === $this) {
                $episode->setSerie(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }

    /**
     * @return string|null
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    /**
     * @param string|null $synopsis
     * @return Serie
     */
    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * @return Collection|Name[]
     */
    public function getNames(): Collection
    {
        return $this->names;
    }

    /**
     * @param Name $name
     * @return Serie
     */
    public function addName(Name $name): self
    {
        if (!$this->names->contains($name)) {
            $this->names[] = $name;
            $name->setSerie($this);
        }

        return $this;
    }

    /**
     * @param Name $name
     * @return Serie
     */
    public function removeName(Name $name): self
    {
        if ($this->names->contains($name)) {
            $this->names->removeElement($name);
            // set the owning side to null (unless already changed)
            if ($name->getSerie() === $this) {
                $name->setSerie(null);
            }
        }

        return $this;
    }

    /**
     * @return Name
     */
    public function getDefaultName(): Name
    {
        foreach ($this->names as $name) {
            if ($name->getIsDefault()) {
                return $name;
            }
        }
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }
}

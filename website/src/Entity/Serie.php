<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
        $this->names = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setSerie($this);
        }

        return $this;
    }

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

    public function __toString(): string
    {
        return "";
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

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

    public function addName(Name $name): self
    {
        if (!$this->names->contains($name)) {
            $this->names[] = $name;
            $name->setSerie($this);
        }

        return $this;
    }

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

    public function getDefaultName(): Name
    {
        foreach($this->names as $name)
        {
            if($name->getIsDefault())
                return $name;
        }
    }
}

<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffresRepository::class)
 */
class Offres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remise;

    /**
     * @ORM\OneToMany(targetEntity=Voyage::class, mappedBy="offres")
     */
    private $voyage;

    public function __construct()
    {
        $this->voyage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(?int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyage(): Collection
    {
        return $this->voyage;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyage->contains($voyage)) {
            $this->voyage[] = $voyage;
            $voyage->setOffres($this);
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyage->removeElement($voyage)) {
            // set the owning side to null (unless already changed)
            if ($voyage->getOffres() === $this) {
                $voyage->setOffres(null);
            }
        }

        return $this;
    }
}

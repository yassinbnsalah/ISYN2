<?php

namespace App\Entity;

use App\Repository\AvionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvionRepository::class)
 */
class Avion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heberg;

    /**
     * @ORM\OneToMany(targetEntity=AvionVoyage::class, mappedBy="av")
     */
    private $avionVoyages;

    public function __construct()
    {
        $this->avionVoyages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(?int $nb_place): self
    {
        $this->nb_place = $nb_place;

        return $this;
    }

    public function getHeberg(): ?string
    {
        return $this->heberg;
    }

    public function setHeberg(?string $heberg): self
    {
        $this->heberg = $heberg;

        return $this;
    }

    /**
     * @return Collection|AvionVoyage[]
     */
    public function getAvionVoyages(): Collection
    {
        return $this->avionVoyages;
    }

    public function addAvionVoyage(AvionVoyage $avionVoyage): self
    {
        if (!$this->avionVoyages->contains($avionVoyage)) {
            $this->avionVoyages[] = $avionVoyage;
            $avionVoyage->setAv($this);
        }

        return $this;
    }

    public function removeAvionVoyage(AvionVoyage $avionVoyage): self
    {
        if ($this->avionVoyages->removeElement($avionVoyage)) {
            // set the owning side to null (unless already changed)
            if ($avionVoyage->getAv() === $this) {
                $avionVoyage->setAv(null);
            }
        }

        return $this;
    }
}

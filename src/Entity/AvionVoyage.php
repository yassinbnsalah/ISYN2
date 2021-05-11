<?php

namespace App\Entity;

use App\Repository\AvionVoyageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvionVoyageRepository::class)
 */
class AvionVoyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Avion::class, inversedBy="avionVoyages")
     */
    private $av;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="avionVoyages")
     */
    private $voy;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAv(): ?Avion
    {
        return $this->av;
    }

    public function setAv(?Avion $av): self
    {
        $this->av = $av;

        return $this;
    }

    public function getVoy(): ?Voyage
    {
        return $this->voy;
    }

    public function setVoy(?Voyage $voy): self
    {
        $this->voy = $voy;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}

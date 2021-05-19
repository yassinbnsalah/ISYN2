<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
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
    private $nb_pers;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reservations")
     */
    private $cl;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="reservations")
     */
    private $Voy;

    /**
     * @ORM\Column(type="date")
     */
    private $DateRes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPers(): ?int
    {
        return $this->nb_pers;
    }

    public function setNbPers(?int $nb_pers): self
    {
        $this->nb_pers = $nb_pers;

        return $this;
    }

    public function getCl(): ?Client
    {
        return $this->cl;
    }

    public function setCl(?Client $cl): self
    {
        $this->cl = $cl;

        return $this;
    }

    public function getVoy(): ?Voyage
    {
        return $this->Voy;
    }

    public function setVoy(?Voyage $Voy): self
    {
        $this->Voy = $Voy;

        return $this;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->DateRes;
    }

    public function setDateRes(\DateTimeInterface $DateRes): self
    {
        $this->DateRes = $DateRes;

        return $this;
    }

    public function getConfirmer(): ?bool
    {
        return $this->confirmer;
    }

    public function setConfirmer(?bool $confirmer): self
    {
        $this->confirmer = $confirmer;

        return $this;
    }
}

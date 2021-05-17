<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_aller;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_retour;

    /**
     * @ORM\ManyToOne(targetEntity=Aeroport::class, inversedBy="voyages")
     */
    private $ar_depart;

    /**
     * @ORM\ManyToOne(targetEntity=Aeroport::class, inversedBy="voyages")
     */
    private $ar_arrive;

    /**
     * @ORM\ManyToOne(targetEntity=Aeroport::class, inversedBy="voyages")
     */
    private $ar_escale;

    /**
     * @ORM\OneToMany(targetEntity=AvionVoyage::class, mappedBy="voy")
     */
    private $avionVoyages;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="Voy")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=VoyageOrg::class, mappedBy="voy")
     */
    private $voyageOrgs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="voy")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $from_Ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $to_Ville;

    public function __construct()
    {
        $this->avionVoyages = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->voyageOrgs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAller(): ?\DateTimeInterface
    {
        return $this->date_aller;
    }

    public function setDateAller(\DateTimeInterface $date_aller): self
    {
        $this->date_aller = $date_aller;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(?\DateTimeInterface $date_retour): self
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getArDepart(): ?Aeroport
    {
        return $this->ar_depart;
    }

    public function setArDepart(?Aeroport $ar_depart): self
    {
        $this->ar_depart = $ar_depart;

        return $this;
    }

    public function getArArrive(): ?Aeroport
    {
        return $this->ar_arrive;
    }

    public function setArArrive(?Aeroport $ar_arrive): self
    {
        $this->ar_arrive = $ar_arrive;

        return $this;
    }

    public function getArEscale(): ?Aeroport
    {
        return $this->ar_escale;
    }

    public function setArEscale(?Aeroport $ar_escale): self
    {
        $this->ar_escale = $ar_escale;

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
            $avionVoyage->setVoy($this);
        }

        return $this;
    }

    public function removeAvionVoyage(AvionVoyage $avionVoyage): self
    {
        if ($this->avionVoyages->removeElement($avionVoyage)) {
            // set the owning side to null (unless already changed)
            if ($avionVoyage->getVoy() === $this) {
                $avionVoyage->setVoy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVoy($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVoy() === $this) {
                $reservation->setVoy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VoyageOrg[]
     */
    public function getVoyageOrgs(): Collection
    {
        return $this->voyageOrgs;
    }

    public function addVoyageOrg(VoyageOrg $voyageOrg): self
    {
        if (!$this->voyageOrgs->contains($voyageOrg)) {
            $this->voyageOrgs[] = $voyageOrg;
            $voyageOrg->setVoy($this);
        }

        return $this;
    }

    public function removeVoyageOrg(VoyageOrg $voyageOrg): self
    {
        if ($this->voyageOrgs->removeElement($voyageOrg)) {
            // set the owning side to null (unless already changed)
            if ($voyageOrg->getVoy() === $this) {
                $voyageOrg->setVoy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setVoy($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getVoy() === $this) {
                $commentaire->setVoy(null);
            }
        }

        return $this;
    }

    public function getFromVille(): ?string
    {
        return $this->from_Ville;
    }

    public function setFromVille(string $from_Ville): self
    {
        $this->from_Ville = $from_Ville;

        return $this;
    }

    public function getToVille(): ?string
    {
        return $this->to_Ville;
    }

    public function setToVille(string $to_Ville): self
    {
        $this->to_Ville = $to_Ville;

        return $this;
    }
}

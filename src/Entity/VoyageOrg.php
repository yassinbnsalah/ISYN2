<?php

namespace App\Entity;

use App\Repository\VoyageOrgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageOrgRepository::class)
 */
class VoyageOrg
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_jour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="voyageOrgs")
     */
    private $voy;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Programme;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="voyage_org", orphanRemoval=true , cascade ={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJour(): ?int
    {
        return $this->nb_jour;
    }

    public function setNbJour(int $nb_jour): self
    {
        $this->nb_jour = $nb_jour;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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

    public function getProgramme(): ?string
    {
        return $this->Programme;
    }

    public function setProgramme(?string $Programme): self
    {
        $this->Programme = $Programme;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVoyageOrg($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getVoyageOrg() === $this) {
                $image->setVoyageOrg(null);
            }
        }

        return $this;
    }
}

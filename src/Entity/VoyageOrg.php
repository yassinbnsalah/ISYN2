<?php

namespace App\Entity;

use App\Repository\VoyageOrgRepository;
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
}

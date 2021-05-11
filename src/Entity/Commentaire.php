<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commentaires")
     */
    private $cl;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="commentaires")
     */
    private $voy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

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
        return $this->voy;
    }

    public function setVoy(?Voyage $voy): self
    {
        $this->voy = $voy;

        return $this;
    }
}

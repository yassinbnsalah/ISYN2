<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageOrg::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyageorg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVoyageOrg(): ?VoyageOrg
    {
        return $this->voyageorg;
    }

    public function setVoyageOrg(?VoyageOrg $voyageorg): self
    {
        $this->voyage_org = $voyageorg;

        return $this;
    }
}

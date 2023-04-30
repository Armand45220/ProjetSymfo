<?php

namespace App\Entity;


use App\Repository\PartenaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Fichier;

#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPart = null;

    #[ORM\Column(length: 1500)]
    private ?string $descPart = null;

    #[ORM\Column(length: 255)]
    private ?string $lienPart = null;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Fichier", inversedBy:"partenaires")]
    #[ORM\JoinColumn(name:"fichier_id", referencedColumnName:"id_fichier")]
    private ?Fichier $fichierPart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPart(): ?string
    {
        return $this-> nomPart;
    }

    public function setNomPart(string $nomPart): self
    {
        $this->nomPart = $nomPart;

        return $this;
    }

    public function getDescPart(): ?string
    {
        return $this->descPart;
    }

    public function setDescPart(string $descPart): self
    {
        $this->descPart = $descPart;

        return $this;
    }

    public function getLienPart(): ?string 
    {
        return $this->lienPart;
    }

    public function setLienPart(string $lienPart): self
    {
        $this->lienPart = $lienPart;

        return $this;
    }
    
    public function getFichierPart(): ?Fichier
    {
        return $this->fichierPart;
    }

    public function setFichierPart(?Fichier $fichierPart): self
    {
        $this->fichierPart = $fichierPart;

        return $this;
    }
    
}
?>
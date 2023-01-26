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
    private ?string $nom_part = null;

    #[ORM\Column(length: 1500)]
    private ?string $desc_part = null;

    #[ORM\Column(length: 255)]
    private ?string $lien_part = null;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Fichier", inversedBy:"Partenaire")]
    #[ORM\JoinColumn(name:"fichier_id", referencedColumnName:"id_fichier")]
    private $fichier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom_part(): ?string
    {
        return $this-> nom_part;
    }

    public function setNomPart(string $nom_part): self
    {
        $this->nom_part = $nom_part;

        return $this;
    }

    public function getDesc_part(): ?string
    {
        return $this->desc_part;
    }

    public function setDesc_part(string $desc_part): self
    {
        $this->desc_part = $desc_part;

        return $this;
    }

    public function getLien_part(): ?string
    {
        return $this->lien_part;
    }

    public function setLienPart(string $lien_part): self
    {
        $this->lien_part = $lien_part;

        return $this;
    }
    
    public function getFichier(): ?Fichier
    {
        return $this->fichier;
    }

    public function setFichier(?Fichier $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }
    
}

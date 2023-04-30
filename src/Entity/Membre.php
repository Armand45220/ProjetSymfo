<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Fichier;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_membre = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_membre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $desc_Membre = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Fichier', inversedBy: 'Membre')]
    #[ORM\JoinColumn(name:"fichier_id", referencedColumnName:"id_fichier")]
    private $fichier;


    public function getIdMembre(): ?int
    {
        return $this->id_membre;
    }

    public function getNomMembre(): ?string
    {
        return $this-> nom_membre;
    }

    public function setNomMembre(?string $nom_membre): self
    {
        $this->nom_membre = $nom_membre;

        return $this;
    }

    public function getDescMembre(): ?string
    {
        return $this->desc_Membre;
    }

    public function setDescMembre(?string $desc_Membre): self
    {
        $this->desc_Membre = $desc_Membre;

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

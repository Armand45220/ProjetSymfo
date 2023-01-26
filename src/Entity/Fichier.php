<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Partenaire;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_fichier = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\Column(length: 255)]
    private ?string $chemin_fichier = null;
    
    #[ORM\OneToMany(mappedBy: 'Fichier', targetEntity:'App\Entity\Partenaire')]
    private $partenaires;

    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id_fichier;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): self
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    public function getChemin_fichier(): ?string
    {
        return $this->chemin_fichier;
    }

    public function setCheminFichier(string $chemin_fichier): self
    {
        $this->chemin_fichier = $chemin_fichier;

        return $this;
    }

    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }
}

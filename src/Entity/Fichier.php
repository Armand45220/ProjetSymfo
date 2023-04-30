<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Membre;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idFichier = null;

    #[ORM\Column(length: 255)]
    private ?string $nomFichier = null;

    #[ORM\Column(length: 255)]
    private ?string $cheminFichier = null;
    
    #[ORM\OneToMany(mappedBy: 'fichierPart', targetEntity:'App\Entity\Partenaire')]
    private $partenaires;

    #[ORM\OneToMany(targetEntity:"App\Entity\FichierOffre", mappedBy:"fichiers")]
    private $fichiersOffres;


    #[ORM\OneToMany(mappedBy: 'Fichier', targetEntity: 'App\Entity\Membre')]
    private $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->fichiersOffres = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->idFichier;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): self
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getCheminFichier(): ?string
    {
        return $this->cheminFichier;
    }

    public function setCheminFichier(string $cheminFichier): self
    {
        $this->cheminFichier = $cheminFichier;

        return $this;
    }
    public function getMembres(): Collection
    {
        return $this->membres;
    }
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function getFichierOffre()
    {
        return $this->fichiersOffres;
    }

    public function getUploadedFile(): ?File
    {
        if (!$this->getCheminFichier()) {
            return null;
        }

        return new File($this->getCheminFichier());
    }

    public function addFichierOffre(FichierOffre $fichierOffre): self
    {
        if (!$this->fichiersOffres->contains($fichierOffre)) {
            $this->fichiersOffres[] = $fichierOffre;
            $fichierOffre->setFichier($this);
        }
        return $this;
    }
}

?>

<?php

namespace App\Entity;

use App\Repository\FichierOffreRepository;  
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierOffreRepository::class)]
class FichierOffre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_fo = null;

    #[ORM\ManyToOne(targetEntity:"Offre")]
    #[ORM\JoinColumn(name:"id_offre", referencedColumnName:"id_offre")]
    private $offres;

    #[ORM\ManyToOne(targetEntity:"Fichier")]
    #[ORM\JoinColumn(name:"id_fichier", referencedColumnName:"id_fichier")]
    private $fichiers;
    
    public function getId(): ?int
    {
        return $this->id_fo;
    }

    public function getOffre(): ?Offre
    {
        return $this->offres;
    }

    public function setOffre(?Offre $offreFichier): self
    {
        $this->offres = $offreFichier;

        return $this;
    }

    public function getFichier(): ?Fichier
    {
        return $this->fichiers;
    }

    public function setFichier(?Fichier $fichierOffre): self
    {
        $this->fichiers = $fichierOffre;
        if ($fichierOffre !== null) {
            $fichierOffre->addFichierOffre($this);
        }

        return $this;
    }
}

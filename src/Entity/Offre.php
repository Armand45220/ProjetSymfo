<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_offre = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_offre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $desc_offre = null;

    #[ORM\Column(length: 255)]
    private ?string $lien_offre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut_val = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_val = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut_aff = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_aff = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_insert_offre = null;

    #[ORM\Column(nullable: true)]
    private ?int $num_aff = null;

    #[ORM\OneToMany(targetEntity:"FichierOffre", mappedBy:"Offre")]
    private $fichierOffre;

    #[ORM\Column(nullable: true)]
    private ?int $nb_places_min = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type_offre = null;

    public function getId(): ?int
    {
        return $this->id_offre;
    }

    public function getNomOffre(): ?string
    {
        return $this->nom_offre;
    }

    public function setNomOffre(string $nom_offre): self
    {
        $this->nom_offre = $nom_offre;

        return $this;
    }

    public function getDescOffre(): ?string
    {
        return $this->desc_offre;
    }

    public function setDescOffre(string $desc_offre): self
    {
        $this->desc_offre = $desc_offre;

        return $this;
    }

    public function getLienOffre(): ?string
    {
        return $this->lien_offre;
    }

    public function setLienOffre(string $lien_offre): self
    {
        $this->lien_offre = $lien_offre;

        return $this;
    }

    public function getDateDebutVal(): ?\DateTimeInterface
    {
        return $this->date_debut_val;
    }

    public function setDateDebutVal(?\DateTimeInterface $date_debut_val): self
    {
        $this->date_debut_val = $date_debut_val;

        return $this;
    }

    public function getDateFinVal(): ?\DateTimeInterface
    {
        return $this->date_fin_val;
    }

    public function setDateFinVal(?\DateTimeInterface $date_fin_val): self
    {
        $this->date_fin_val = $date_fin_val;

        return $this;
    }

    public function getDateDebutAff(): ?\DateTimeInterface
    {
        return $this->date_debut_aff;
    }

    public function setDateDebutAff(?\DateTimeInterface $date_debut_aff): self
    {
        $this->date_debut_aff = $date_debut_aff;

        return $this;
    }

    public function getDateFinAff(): ?\DateTimeInterface
    {
        return $this->date_fin_aff;
    }

    public function setDateFinAff(?\DateTimeInterface $date_fin_aff): self
    {
        $this->date_fin_aff = $date_fin_aff;

        return $this;
    }

    public function getNumAff(): ?int
    {
        return $this->num_aff;
    }

    public function setNumAff(?int $num_aff): self
    {
        $this->num_aff = $num_aff;

        return $this;
    }

    public function getFichierOffre(): Collection
    {
        return $this->fichierOffre;
    }

    public function getNbPlacesMin(): ?int
    {
        return $this->nb_places_min;
    }

    public function setNbPlacesMin(?int $nb_places_min): self
    {
        $this->nb_places_min = $nb_places_min;

        return $this;
    }

    public function getTypeOffre(): ?int
    {
        return $this->type_offre;
    }

    public function setTypeOffre(int $type_offre): self
    {
        $this->type_offre = $type_offre;

        return $this;
    }

    public function getDateInsertOffre(): ?\DateTimeInterface
    {
        return $this->date_insert_offre;
    }

    public function setDateInsertOffre(\DateTimeInterface $date_insert_offre): self
    {
        $this->date_insert_offre = $date_insert_offre;

        return $this;
    }

}

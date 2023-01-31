<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_rep = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_rep = null;

    #[ORM\Column]
    private ?int $nb_rep = null;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Question", inversedBy:"Reponse")]
    #[ORM\JoinColumn(name:"id_question", referencedColumnName:"id_question")]
    private $questions;

    public function getId(): ?int
    {
        return $this->id_rep;
    }

    public function getLibelleRep(): ?string
    {
        return $this->libelle_rep;
    }

    public function setLibelleRep(string $libelle_rep): self
    {
        $this->libelle_rep = $libelle_rep;

        return $this;
    }

    public function getNbRep(): ?int
    {
        return $this->nb_rep;
    }

    public function setNbRep(int $nb_rep): self
    {
        $this->nb_rep = $nb_rep;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->questions;
    }

    public function setQuestion(?Question $questions): self
    {
        $this->questions = $questions;

        return $this;
    }
}

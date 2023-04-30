<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_question = null;

    #[ORM\Column(length: 255)]
    private ?string $txt_question = null;

    
    #[ORM\OneToMany(mappedBy:"Reponse", targetEntity:'App\Entity\Reponse')]
    private $reponses;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $dispo_question = null;

    public function __toString()
    {
        return $this->txt_question;
    }

    public function getId(): ?int
    {
        return $this->id_question;
    }

    public function getTxtQuestion(): ?string
    {
        return $this->txt_question;
    }

    public function setTxtQuestion(string $txt_question): self
    {
        $this->txt_question = $txt_question;

        return $this;
    }

    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function getDispoQuestion(): ?int
    {
        return $this->dispo_question;
    }

    public function setDispoQuestion(int $dispo_question): self
    {
        $this->dispo_question = $dispo_question;

        return $this;
    }
}

?>
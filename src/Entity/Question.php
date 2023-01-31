<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
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
}

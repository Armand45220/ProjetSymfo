<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_act = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_act = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $desc_act = null;


    public function getIdAct(): ?int
    {
        return $this->id_act;
    }

    public function getNomAct(): ?string
    {
        return $this->nom_act;
    }

    public function setNomAct(?string $nom_act): self
    {
        $this->nom_act = $nom_act;

        return $this;
    }

    public function getDescAct(): ?string
    {
        return $this->desc_act;
    }

    public function setDescAct(?string $desc_act): self
    {
        $this->desc_act = $desc_act;

        return $this;
    }

}

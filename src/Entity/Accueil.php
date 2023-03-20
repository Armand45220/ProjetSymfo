<?php

namespace App\Entity;

use App\Repository\AccueilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccueilRepository::class)]
class Accueil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_acc = null;

    #[ORM\Column(length: 3000, nullable: true)]
    private ?string $messPresAcc = null;

    public function getId(): ?int
    {
        return $this->id_acc;
    }

    public function getMessPresAcc(): ?string
    {
        return $this->messPresAcc;
    }

    public function setMessPresAcc(?string $mess_pres_acc): self
    {
        $this->messPresAcc = $mess_pres_acc;

        return $this;
    }
}

?>

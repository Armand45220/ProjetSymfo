<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_admin = null;

    #[ORM\Column(length: 255)]
    private ?string $uti_admin = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp_admin = null;

    public function getId(): ?int
    {
        return $this->id_admin;
    }

    public function getUtiAdmin(): ?string
    {
        return $this->uti_admin;
    }

    public function setUtiAdmin(string $uti_admin): self
    {
        $this->uti_admin = $uti_admin;

        return $this;
    }

    public function getMdpAdmin(): ?string
    {
        return $this->mdp_admin;
    }

    public function setMdpAdmin(string $mdp_admin): self
    {
        $this->mdp_admin = $mdp_admin;

        return $this;
    }
}

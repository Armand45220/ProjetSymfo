<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_cont = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_cont = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom_cont = null;

    #[ORM\Column(length: 255)]
    private ?string $mail_cont = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $inscription_cont = null;

    #[ORM\OneToMany(mappedBy:"Contact", targetEntity:'App\Entity\MessUtilisateur')]
    private $messUti;

    public function getId(): ?int
    {
        return $this->id_cont;
    }

    public function getNomCont(): ?string
    {
        return $this->nom_cont;
    }

    public function setNomCont(?string $nom_cont): self
    {
        $this->nom_cont = $nom_cont;

        return $this;
    }

    public function getPrenomCont(): ?string
    {
        return $this->prenom_cont;
    }

    public function setPrenomCont(?string $prenom_cont): self
    {
        $this->prenom_cont = $prenom_cont;

        return $this;
    }

    public function getMailCont(): ?string
    {
        return $this->mail_cont;
    }

    public function setMailCont(string $mail_cont): self
    {
        $this->mail_cont = $mail_cont;

        return $this;
    }

    public function getInscriptionCont(): ?int
    {
        return $this->inscription_cont;
    }

    public function setInscriptionCont(?int $inscription_cont): self
    {
        $this->inscription_cont = $inscription_cont;

        return $this;
    }

    public function getMess(): Collection
    {
        return $this->messUti;
    }
}

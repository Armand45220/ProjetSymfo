<?php

namespace App\Entity;

use App\Repository\MessUtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessUtilisateurRepository::class)]
class MessUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_mess = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $libelle_mess = null;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Contact", inversedBy:"MessUtilisateur")]
    #[ORM\JoinColumn(name:"contact_id", referencedColumnName:"id_cont")]
    private $contacts;

    public function getId(): ?int
    {
        return $this->id_mess;
    }

    public function getLibelleMess(): ?string
    {
        return $this->libelle_mess;
    }

    public function setLibelleMess(?string $libelle_mess): self
    {
        $this->libelle_mess = $libelle_mess;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contacts;
    }

    public function setContact(?Contact $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email_notif = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $inscription_notif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailNotif(): ?string
    {
        return $this->email_notif;
    }

    public function setEmailNotif(string $email_notif): self
    {
        $this->email_notif = $email_notif;

        return $this;
    }

    public function getInscriptionNotif(): ?int
    {
        return $this->inscription_notif;
    }

    public function setInscriptionNotif(?int $inscription_notif): self
    {
        $this->inscription_notif = $inscription_notif;

        return $this;
    }
}

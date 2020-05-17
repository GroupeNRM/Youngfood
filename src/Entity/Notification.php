<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(mercure="true")
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Notif_Title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $Notif_Text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Notif_Date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotifTitle(): ?string
    {
        return $this->Notif_Title;
    }

    public function setNotifTitle(string $Notif_Title): self
    {
        $this->Notif_Title = $Notif_Title;

        return $this;
    }

    public function getNotifText(): ?string
    {
        return $this->Notif_Text;
    }

    public function setNotifText(string $Notif_Text): self
    {
        $this->Notif_Text = $Notif_Text;

        return $this;
    }

    public function getNotifDate(): ?\DateTimeInterface
    {
        return $this->Notif_Date;
    }

    public function setNotifDate(): self
    {
        $this->Notif_Date = new \DateTime();

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserOrderRepository::class)
 */
class UserOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Child::class, inversedBy="userOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $child_id;

    /**
     * @ORM\ManyToOne(targetEntity=Booking::class, inversedBy="userOrders")
     */
    private $booking_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildId(): ?Child
    {
        return $this->child_id;
    }

    public function setChildId(?Child $child_id): self
    {
        $this->child_id = $child_id;

        return $this;
    }

    public function getBookingId(): ?Booking
    {
        return $this->booking_id;
    }

    public function setBookingId(?Booking $booking_id): self
    {
        $this->booking_id = $booking_id;

        return $this;
    }
}

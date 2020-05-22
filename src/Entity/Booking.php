<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ApiResource(
 *     collectionOperations={"post", "get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"booking:read"}},
 *     denormalizationContext={"groups"={"booking:write"}}
 * )
 * @ApiFilter(DateFilter::class, properties={"date"})
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Meal::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"booking:read", "booking:write", "meal:read"})
     */
    private $meal;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"booking:read", "booking:write"})
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 * @ApiResource(
 *     collectionOperations={"post", "get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"meal:read"}},
 *     denormalizationContext={"groups"={"meal:write"}}
 * )
 */
class Meal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"meal:read", "meal:write"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"meal:read", "meal:write", "booking:read", "food:read"})
     */
    private $entree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"meal:read", "meal:write", "booking:read", "food:read"})
     */
    private $maindish;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"meal:read", "meal:write", "booking:read"})
     */
    private $dessert;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"meal:read", "meal:write", "booking:read"})
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="meal")
     * @Groups({"meal:read", "meal:write", "booking:read"})
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntree(): ?Food
    {
        return $this->entree;
    }

    public function setEntree(?Food $entree): self
    {
        $this->entree = $entree;

        return $this;
    }

    public function getMaindish(): ?Food
    {
        return $this->maindish;
    }

    public function setMaindish(?Food $maindish): self
    {
        $this->maindish = $maindish;

        return $this;
    }

    public function getDessert(): ?Food
    {
        return $this->dessert;
    }

    public function setDessert(?Food $dessert): self
    {
        $this->dessert = $dessert;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
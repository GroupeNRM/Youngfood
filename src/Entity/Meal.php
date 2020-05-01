<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(mercure=true)
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="entree")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="main_dish")
     * @ORM\JoinColumn(nullable=false)
     */
    private $main_dish;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food", inversedBy="dessert")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dessert;

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

    public function getMainDish(): ?Food
    {
        return $this->main_dish;
    }

    public function setMainDish(?Food $main_dish): self
    {
        $this->main_dish = $main_dish;

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
}

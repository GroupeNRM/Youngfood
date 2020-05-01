<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
    public function __construct()
    {
        $this->entree = new ArrayCollection();
        $this->main_dish = new ArrayCollection();
        $this->dessert = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *     max = "50",
     *     maxMessage = "L'intutilé ne peut pas dépasser {{ limit }} caractères.",
     *     allowEmptyString = false
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @Assert\Length(
     *     max = "1"
     * )
     * @ORM\Column(type="string", length=1)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meal", mappedBy="entree", orphanRemoval=true)
     */
    private $entree;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meal", mappedBy="main_dish", orphanRemoval=true)
     */
    private $main_dish;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meal", mappedBy="dessert", orphanRemoval=true)
     */
    private $dessert;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getEntree(): Collection
    {
        return $this->entree;
    }

    public function addEntree(Meal $entree): self
    {
        if (!$this->entree->contains($entree)) {
            $this->entree[] = $entree;
            $entree->setEntree($this);
        }

        return $this;
    }

    public function removeEntree(Meal $entree): self
    {
        if ($this->entree->contains($entree)) {
            $this->entree->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getEntree() === $this) {
                $entree->setEntree(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMainDish(): Collection
    {
        return $this->main_dish;
    }

    public function addMainDish(Meal $mainDish): self
    {
        if (!$this->main_dish->contains($mainDish)) {
            $this->main_dish[] = $mainDish;
            $mainDish->setMainDish($this);
        }

        return $this;
    }

    public function removeMainDish(Meal $mainDish): self
    {
        if ($this->main_dish->contains($mainDish)) {
            $this->main_dish->removeElement($mainDish);
            // set the owning side to null (unless already changed)
            if ($mainDish->getMainDish() === $this) {
                $mainDish->setMainDish(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getDessert(): Collection
    {
        return $this->dessert;
    }

    public function addDessert(Meal $dessert): self
    {
        if (!$this->dessert->contains($dessert)) {
            $this->dessert[] = $dessert;
            $dessert->setDessert($this);
        }

        return $this;
    }

    public function removeDessert(Meal $dessert): self
    {
        if ($this->dessert->contains($dessert)) {
            $this->dessert->removeElement($dessert);
            // set the owning side to null (unless already changed)
            if ($dessert->getDessert() === $this) {
                $dessert->setDessert(null);
            }
        }

        return $this;
    }
}

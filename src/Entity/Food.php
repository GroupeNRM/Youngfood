<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
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
     * @ORM\OneToMany(targetEntity=Platlike::class, mappedBy="plat")
     */
    //private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

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
     * @return Collection|Platlike[]
     */
  /*   public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Platlike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPlat($this);
        }

        return $this;
    } */
/* 
    public function removeLike(Platlike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getPlat() === $this) {
                $like->setPlat(null);
            }
        }

        return $this;
    } */

    /**
     * permet de savoir si cet plat est déjà "liké" par l'utilisateur
     *
     * @param User $user
     * 
     * @return boolean
     */
  /*   public function isLikeByUser(User $user) :bool
    {
        foreach ($this->likes as $like) {

            if ($like->getUser() == $user) return true;
            
        }

        return false;
    } */
}

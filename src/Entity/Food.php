<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"food:read"}},
 *     denormalizationContext={"groups"={"food:write"}}
 *  )
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 * @ApiFilter(SearchFilter::class, properties={"category": "exact"})
 */
class Food
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"food:read", "food:write"})
     */
    private $id;

    /**
     * @Assert\Length(
     *     max = "50",
     *     maxMessage = "L'intutilé ne peut pas dépasser {{ limit }} caractères.",
     *     allowEmptyString = false
     * )
     * @ORM\Column(type="string", length=50)
     * @Groups({"food:read", "food:write", "booking:read"})
     */
    private $title;

    /**
     * @Assert\Length(
     *     max = "1"
     * )
     * @ORM\Column(type="string", length=1)
     * @Groups({"food:read", "food:write", "booking:read"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"food:read", "food:write", "booking:read"})
     */
    private $picture;

    /**
     * @Assert\Length(
     *     max = "250"
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"food:read", "food:write"})
     */
    private $information;

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

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }
}

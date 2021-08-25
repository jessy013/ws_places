<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, inversedBy="likedBy")
     * @Groups("person:read")
     */
    private $placesLiked;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("person:read")
     * @Groups("place:read")
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("person:read")
     * @Groups("place:read")
     */
    private $FirstName;

    public function __construct()
    {
        $this->placesLiked = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|place[]
     */
    public function getPlacesLiked(): Collection
    {
        return $this->placesLiked;
    }

    public function addPlacesLiked(place $placesLiked): self
    {
        if (!$this->placesLiked->contains($placesLiked)) {
            $this->placesLiked[] = $placesLiked;
        }

        return $this;
    }

    public function removePlacesLiked(place $placesLiked): self
    {
        $this->placesLiked->removeElement($placesLiked);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }
}

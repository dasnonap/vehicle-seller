<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car extends Vehicle
{
    #[ORM\Column]
    private ?float $engine_capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $colour = null;

    #[ORM\Column]
    private ?int $doors = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    public function getEngineCapacity(): ?float
    {
        return $this->engine_capacity;
    }

    public function setEngineCapacity(float $engine_capacity): static
    {
        $this->engine_capacity = $engine_capacity;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(string $colour): static
    {
        $this->colour = $colour;

        return $this;
    }

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): static
    {
        $this->doors = $doors;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TruckRepository::class)]
class Truck extends Vehicle
{
    #[ORM\Column]
    private ?float $engine_capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $colour = null;

    #[ORM\Column]
    private ?int $number_of_beds = null;

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

    public function getNumberOfBeds(): ?int
    {
        return $this->number_of_beds;
    }

    public function setNumberOfBeds(int $number_of_beds): static
    {
        $this->number_of_beds = $number_of_beds;

        return $this;
    }

    public function initFromArray(array $args): void
    {
        $this->setEngineCapacity($args['engine_capacity']);
        $this->setColour($args['colour']);
        $this->setNumberOfBeds($args['number_of_beds']);
    }
}

<?php

namespace App\Entity;

use App\Repository\MotorcycleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotorcycleRepository::class)]
class Motorcycle extends Vehicle
{
    #[ORM\Column]
    private ?float $engine_capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $colour = null;

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

    public function initFromArray(array $args): void
    {
        $this->setEngineCapacity($args['engine_capacity']);
        $this->setColour($args['colour']);
    }

    public function toArray(): array
    {
        return [
            'vehicle_specs' => parent::toArray(),
            'type_specs' => [
                'engine_capacity' => $this->engine_capacity,
                'colour' => $this->colour,
                'type' => 'Motorcycle'
            ]
        ];
    }
}

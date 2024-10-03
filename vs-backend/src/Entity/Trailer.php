<?php

namespace App\Entity;

use App\Repository\TrailerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrailerRepository::class)]
class Trailer extends Vehicle
{
    #[ORM\Column]
    private ?int $load_capacity = null;

    #[ORM\Column]
    private ?int $number_of_axles = null;

    public function getLoadCapacity(): ?int
    {
        return $this->load_capacity;
    }

    public function setLoadCapacity(int $load_capacity): static
    {
        $this->load_capacity = $load_capacity;

        return $this;
    }

    public function getNumberOfAxles(): ?int
    {
        return $this->number_of_axles;
    }

    public function setNumberOfAxles(int $number_of_axles): static
    {
        $this->number_of_axles = $number_of_axles;

        return $this;
    }

    public function initFromArray(array $args): void
    {
        $this->setLoadCapacity($args['load_capacity']);
        $this->setNumberOfAxles($args['number_of_axles']);
    }
}

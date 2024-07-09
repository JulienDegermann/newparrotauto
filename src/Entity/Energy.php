<?php

namespace App\Entity;

use App\Entity\Car;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\EnergyRepository;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: EnergyRepository::class)]
class Energy
{
    use IdTrait;
    use DatesTrait;
    use NameTrait;

    #[ORM\OneToMany(
        targetEntity: Car::class,
        mappedBy: 'energy',
        orphanRemoval: true,
        cascade: ['persist', 'remove']
    )]
    private Collection $cars;

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setEnergy($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

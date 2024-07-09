<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ModelRepository;
use App\Traits\Entities\DatesTrait;
use App\Traits\Entities\NameTrait;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    use IdTrait;
    use DatesTrait;
    use NameTrait;

    #[ORM\ManyToOne(inversedBy: 'models')]
    private ?Brand $brand = null;

    #[ORM\OneToMany(
        targetEntity: Car::class,
        mappedBy: 'model',
        orphanRemoval: true,
        cascade: ['persist', 'remove']
    )]
    private Collection $cars;

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        $this->cars->removeElement($car);

        return $this;
    }

    public function __toString(): string
    {
        return strtoupper($this->getBrand()->getName()) . ' ' . strtoupper($this->name);
    }
}

<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\DatesTrait;
use App\Repository\EquipmentRepository;
use App\Traits\Entities\TextTrait;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    use IdTrait;
    use DatesTrait;
    use TextTrait;

    /**
     * @var Collection<int, Car>
     */
    #[ORM\ManyToMany(targetEntity: Car::class, inversedBy: 'equipments')]
    private Collection $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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
            $car->addEquipment($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            $car->removeEquipment($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getText();
    }
}

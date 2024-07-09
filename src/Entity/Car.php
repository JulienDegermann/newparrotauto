<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use App\Traits\Entities\DatesTrait;
use App\Traits\Entities\TextTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    use IdTrait;
    use DatesTrait;
    use TextTrait;

    #[ORM\Column]
    private ?int $mileAge = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Le champ obligatoire.'
        ),
        new Assert\Type(
            type: 'DateTimeInterface',
            message: 'Le champ doit être une date.'
        ),
        new Assert\LessThanOrEqual(
            value: 'now',
            message: 'La date doit être antérieure ou égale à la date actuelle.'
        )
    ])]
    private ?\DateTimeImmutable $circulationDate = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Energy $energy = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?User $author = null;

    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var Collection<int, Equipment>
     */
    #[ORM\ManyToMany(
        targetEntity: Equipment::class,
        mappedBy: 'cars'
    )]
    private Collection $equipments;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Image::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getMileAge(): ?int
    {
        return $this->mileAge;
    }

    public function setMileAge(int $mileAge): static
    {
        $this->mileAge = $mileAge;

        return $this;
    }

    public function getCirculationDate(): ?\DateTimeImmutable
    {
        return $this->circulationDate;
    }

    public function setCirculationDate(\DateTimeImmutable $circulationDate): static
    {
        $this->circulationDate = $circulationDate;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getModel()->getName() . ' ' . $this->getCirculationDate()->format('Y');
    }

    /**
     * @return Collection<int, Equipments>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
            $equipment->addCar($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        if ($this->equipments->removeElement($equipment)) {
            $equipment->removeCar($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getCar() === $this) {
                $image->setCar(null);
            }
        }

        return $this;
    }
}

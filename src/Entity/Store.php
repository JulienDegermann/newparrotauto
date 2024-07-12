<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\TextTrait;
use App\Repository\StoreRepository;
use App\Traits\Entities\DatesTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
class Store
{
    use IdTrait;
    use DatesTrait;

    #[ORM\Column]
    #[Groups(['storeUpdate'])]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['storeUpdate'])]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'stores')]
    private ?Company $company;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'store')]
    private ?Collection $employees;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['storeUpdate'])]
    private ?string $city;

    #[ORM\OneToMany(
        targetEntity: Opening::class,
        mappedBy: 'store',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
        fetch: 'EAGER'
   
    )]
    #[Groups(['storeUpdate'])]
    private Collection $openings;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(User $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
        }

        return $this;
    }

    public function removeEmployee(User $employee): static
    {
        $this->employees->removeElement($employee);

        return $this;
    }

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->openings = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city)
    {
        $this->city = $city;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getCity();
    }


    /**
     * @return Collection<int, Opening>
     */
    public function getOpenings(): ?Collection
    {
        return $this->openings;
    }

    public function addOpening(Opening $opening): static
    {
        if (!$this->openings->contains($opening)) {
            $this->openings->add($opening);
            $opening->setStore($this);
        }

        return $this;
    }

    public function removeOpening(Opening $opening): static
    {
        if ($this->openings->removeElement($opening)) {
            if ($opening->getStore() === $this) {
                $opening->setStore(null);
            }
        }

        return $this;
    }
}

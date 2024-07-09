<?php

namespace App\Entity;

use App\Entity\Store;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CityRepository;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\DatesTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    use IdTrait;
    use NameTrait;
    use DatesTrait;

    #[ORM\Column]
    private ?string $zipCode = null;

    #[ORM\Column]
    private ?string $inseeCode = null;

    #[ORM\OneToMany(targetEntity: Store::class, mappedBy: 'city')]
    private Collection $stores;

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getInseeCode(): ?string
    {
        return $this->inseeCode;
    }

    public function setInseeCode(string $inseeCode): static
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }


    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): static
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
            $store->setCity($this);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        if ($this->stores->removeElement($store)) {
            // set the owning side to null (unless already changed)
            if ($store->getCity() === $this) {
                $store->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function __construct()
    {
        $this->stores = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->getName() . " (" . $this->getZipCode() . ")";
    }


}

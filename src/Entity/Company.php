<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\TextTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use DatesTrait;
    use IdTrait;
    use NameTrait;
    use TextTrait;

    #[ORM\OneToMany(
        targetEntity: Store::class,
        mappedBy: 'company'
    )]
    private $stores;

    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): static
    {
        if (!$this->stores->contains($store)) {
            $this->stores->add($store);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        $this->stores->removeElement($store);

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->stores = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Repository\BrandRepository;
use App\Traits\Entities\DatesTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    use IdTrait;
    use DatesTrait;
    use NameTrait;
    
    /**
     * @var Collection<int, Model>
     */
    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: 'brand', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): static
    {
        if (!$this->models->contains($model)) {
            $this->models->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): static
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

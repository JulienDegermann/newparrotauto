<?php

namespace App\Entity;

use App\Repository\OpeningRepository;
use App\Traits\Entities\DatesTrait;
use App\Traits\Entities\IdTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningRepository::class)]
class Opening
{
    use IdTrait;
    use DatesTrait;
    
    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $open = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $close = null;

    #[ORM\ManyToOne(inversedBy: 'openings')]
    private ?Store $store = null;

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpen(): ?\DateTimeInterface
    {
        return $this->open;
    }

    public function setOpen(\DateTimeInterface $open): static
    {
        $this->open = $open;

        return $this;
    }

    public function getClose(): ?\DateTimeInterface
    {
        return $this->close;
    }

    public function setClose(\DateTimeInterface $close): static
    {
        $this->close = $close;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): static
    {
        $this->store = $store;

        return $this;
    }

    public function __toString(): string
    {
        return $this->day . ' ' . $this->open->format('H:i') . ' - ' . $this->close->format('H:i');
    }
}

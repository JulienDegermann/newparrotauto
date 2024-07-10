<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use App\Traits\Entities\DatesTrait;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\MagicConst\File;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use IdTrait;
    use DatesTrait;

    private ?File $file = null;

    private ?int $size = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $fileName = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Car $car = null;

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): static
    {
        $this->fileName = $fileName;

        if ($fileName) {
            $this->setUpdatedAt(new \DateTimeImmutable('now'));
        }

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function __toString(): string
    {
        return $this->fileName;
    }
}

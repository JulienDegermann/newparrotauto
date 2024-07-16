<?php

namespace App\Traits\Entities;

use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DatesTrait
{
  #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
  #[Assert\Sequentially([
    new Assert\NotBlank(
      message: 'Le champ est obligatoire.'
    ),
    new Assert\Type(
      type: \DateTimeImmutable::class,
      message: 'Le champ doit être une date.'
    ),
    new Assert\LessThanOrEqual(
      value: 'now',
      message: 'La date doit être antérieure ou égale à la date actuelle.'
    )
  ])]
  private ?DateTimeImmutable $createdAt = null;

  #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
  #[Assert\Sequentially([
    new Assert\NotBlank(
      message: 'Le champ obligatoire.'
    ),
    new Assert\Type(
      type: \DateTimeImmutable::class,
      message: 'Le champ doit être une date.'
    ),
    new Assert\LessThanOrEqual(
      value: 'now',
      message: 'La date doit être antérieure ou égale à la date actuelle.'
    )
  ])]
  private ?DateTimeImmutable $updatedAt = null;

  public function setCreatedAt(DateTimeImmutable $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function setUpdatedAt(DateTimeImmutable $updatedAt): static
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  public function getCreatedAt(): ?DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function getUpdatedAt(): ?DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function __construct()
  {
    $this->createdAt = new DateTimeImmutable('now');
    $this->updatedAt = new DateTimeImmutable('now');
  }
}

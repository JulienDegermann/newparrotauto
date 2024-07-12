<?php

namespace App\Traits\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait NameTrait
{
  #[ORM\Column(type: 'string', length: 255)]
  #[Assert\Sequentially([
    new Assert\NotBlank(
      message: 'Le champ est obligatoire.'
    ),
    new Assert\Type(
      type: 'string',
      message: 'Le champ doit être une chaîne de caractères.'
    ),
    new Assert\Length(
      min: 2,
      max: 255,
      minMessage: 'Le champ doit contenir au moins {{ limit }} caractères.',
      maxMessage: 'Le champ doit contenir au maximum {{ limit }} caractères.'
    ),
    new Assert\Regex(
      pattern: '/^[a-zA-Z0-9\s\-\p{L}]{2,255}$/u',
      message: 'Le champ contient des caractères non autorisés.'
  )
  ])]
  private ?string $name = null;

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }
}

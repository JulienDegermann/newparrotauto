<?php

namespace App\Traits\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait TextTrait
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
      minMessage: 'Le champ doit contenir au moins {{ limit }} caractères.',
    ),
    new Assert\Regex(
      pattern: '/^[a-zA-Z0-9\s\.\,\'\-\p{L}]{2,}$/u',
      message: 'Ce champ contient des caractères non autorisés.'
  )
  ])]
  private ?string $text = null;

  public function getText(): ?string
  {
    return $this->text;
  }

  public function setText(string $text): static
  {
    $this->text = $text;

    return $this;
  }
}

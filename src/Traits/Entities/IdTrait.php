<?php

namespace App\Traits\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'integer',
            message: 'Le champ doit être un entier.'
        ),
        new Assert\Positive(
            message: 'Le champ doit être un entier positif.'
        )
    ])]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\TextTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\CommentRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use IdTrait;
    use DatesTrait;
    use NameTrait;
    use TextTrait;

    #[ORM\Column(type: Types::BOOLEAN)]
    #[Assert\Sequentially([
        // new Assert\NotBlank(
        //     message: 'Le champ est obligatoire.'
        // ),
        new Assert\Type(
            type: 'boolean',
            message: 'Le champ doit être un booléen.'
        )
    ])]
    private bool $published = false;


    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Le champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'integer',
            message: 'Le champ doit être une nombre entier.'
        ),
        new Assert\Range(
            min: 1,
            max: 5,
            notInRangeMessage: 'La valeur doit être comprise entre {{ min }} et {{ max }}.'
        )
    ])]
    private ?int $note = null;

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getPublished(): bool
    {
        return $this->published;
    }

    public function setNote(?int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }
}

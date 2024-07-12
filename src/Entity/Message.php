<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\TextTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\MessageRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    use IdTrait;
    use DatesTrait;
    use TextTrait;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Sequentially([
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
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $title = null;

    public function getName(): ?string
    {
        return $this->title;
    }

    public function setName(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages', cascade: ['persist', 'remove'])]
    #[Assert\Valid]
    private ?User $author;

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getText();
    }
}

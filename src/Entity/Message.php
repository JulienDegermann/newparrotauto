<?php

namespace App\Entity;

use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\TextTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\MessageRepository;
use App\Traits\Entities\NameTrait;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    use IdTrait;
    use DatesTrait;
    use TextTrait;
    use NameTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages', cascade: ['persist', 'remove'])]
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

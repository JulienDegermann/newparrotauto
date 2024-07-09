<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entities\NameTrait;
use App\Traits\Entities\TextTrait;
use App\Traits\Entities\DatesTrait;
use App\Repository\CommentRepository;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use IdTrait;
    use DatesTrait;
    use NameTrait;
    use TextTrait;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $published = false;

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getPublished(): bool
    {
        return $this->published;
    }
}

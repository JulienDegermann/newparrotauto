<?php

namespace App\Entity;

use DateTime;
use App\Entity\Message;
use App\Traits\Entities\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Traits\Entities\DatesTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    use IdTrait;
    use DatesTrait;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Sequentially([
        new Assert\NotBlank(
            message: 'Le champ est obligatoire.'
        ),
        new Assert\Type(
            type: 'string',
            message: 'Le champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 4,
            max: 255,
            minMessage: 'Le champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Le champ doit contenir au maximum {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/',
            message: 'E-mail non valide.'
        )
    ])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $password = null;

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
            pattern: '/^[a-zA-Z\s\-\p{L}]{2,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $firstName = null;

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
            pattern: '/^[a-zA-Z\s\-\p{L}]{2,255}$/u',
            message: 'Ce champ contient des caractères non autorisés.'
        )
    ])]
    private ?string $lastName = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Sequentially([
        new Assert\Type(
            type: \DateTimeImmutable::class,
            message: 'Le champ doit être une date.'
        ),
        new Assert\LessThanOrEqual(
            value: 'now',
            message: 'La date doit être antérieure ou égale à la date actuelle.'
        )
    ])]
    private ?DateTime $birthDate = null;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Sequentially([
        new Assert\Type(
            type: 'string',
            message: 'Le champ doit être une chaîne de caractères.'
        ),
        new Assert\Length(
            min: 10,
            max: 12,
            minMessage: 'Le champ doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Le champ doit contenir au maximum {{ limit }} caractères.'
        ),
        new Assert\Regex(
            pattern: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2,})$/',
            message: 'Numéro de téléphone non valide.'
        )
    ])]
    private ?string $phone = null;

    #[ORM\OneToMany(
        targetEntity: Car::class,
        mappedBy: 'author'
    )]
    private Collection $cars;

    #[ORM\ManyToOne(targetEntity: Store::class, inversedBy: 'employees')]
    private ?Store $store = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $messages;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getMessages(): ?Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    /**
     * @param Car $car
     */
    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setAuthor($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getAuthor() === $this) {
                $car->setAuthor(null);
            }
        }

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


    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->cars = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
}

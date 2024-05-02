<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 4,
        max: 180,
        minMessage: 'Votre email doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Votre email doit faire au maximum {{ limit }} caractères',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 1,
        max: 256,
        minMessage: 'Votre message doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Votre message doit faire au maximum {{ limit }} caractères',
    )]
    private ?string $message = null;

    #[ORM\Column(length: 32)]
    #[Assert\Length(
        min: 3,
        max: 32,
        minMessage: 'Votre prénom doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Votre prénom doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9]+$/i',
        htmlPattern: '^[a-zA-Z0-9]+$'
    )]
    private ?string $first_name = null;

    #[ORM\Column(length: 32)]
    #[Assert\Length(
        min: 2,
        max: 32,
        minMessage: 'Votre nom doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Votre nom doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9]+$/i',
        htmlPattern: '^[a-zA-Z0-9]+$'
    )]
    private ?string $last_name = null;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }
}

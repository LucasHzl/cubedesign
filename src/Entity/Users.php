<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;
    #[Assert\Length(
        min: 4,
        max: 180,
        minMessage: 'Votre email doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Votre email doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9]+$/i',
        htmlPattern: '^[a-zA-Z0-9]+$'
    )]

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;
    #[Assert\Length(
        min: 6, 
        minMessage: 'Votre email doit faire au minimum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9]+$/i',
        htmlPattern: '^[a-zA-Z0-9]+$'
    )]

    #[ORM\Column(length: 32)]
    private ?string $firstName = null;
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

    #[ORM\Column(length: 32)]
    private ?string $lastName = null;
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

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\OneToMany(targetEntity: Orders::class, mappedBy: 'user')]
    private Collection $relation_users_orders;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'user')]
    private Collection $relation_users_cart;

    public function __construct()
    {
        $this->relation_users_orders = new ArrayCollection();
        $this->relation_users_cart = new ArrayCollection();
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

    /**
     * @return Collection<int, Orders>
     */
    public function getRelationUsersOrders(): Collection
    {
        return $this->relation_users_orders;
    }

    public function addRelationUsersOrder(Orders $relationUsersOrder): static
    {
        if (!$this->relation_users_orders->contains($relationUsersOrder)) {
            $this->relation_users_orders->add($relationUsersOrder);
            $relationUsersOrder->setUser($this);
        }

        return $this;
    }

    public function removeRelationUsersOrder(Orders $relationUsersOrder): static
    {
        if ($this->relation_users_orders->removeElement($relationUsersOrder)) {
            // set the owning side to null (unless already changed)
            if ($relationUsersOrder->getUser() === $this) {
                $relationUsersOrder->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getRelationUsersCart(): Collection
    {
        return $this->relation_users_cart;
    }

    public function addRelationUsersCart(Cart $relationUsersCart): static
    {
        if (!$this->relation_users_cart->contains($relationUsersCart)) {
            $this->relation_users_cart->add($relationUsersCart);
            $relationUsersCart->setUser($this);
        }

        return $this;
    }

    public function removeRelationUsersCart(Cart $relationUsersCart): static
    {
        if ($this->relation_users_cart->removeElement($relationUsersCart)) {
            // set the owning side to null (unless already changed)
            if ($relationUsersCart->getUser() === $this) {
                $relationUsersCart->setUser(null);
            }
        }

        return $this;
    }
}

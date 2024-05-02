<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relation_users_orders')]
    private ?Users $user = null;

   
    
    #[Assert\Length(
        min: 5,
        max: 5,
        minMessage: 'Le numéro de commande doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Le numéro de commande doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/i',
        htmlPattern: '^[0-9]+$'
    )]
    #[Assert\PositiveOrZero]
    #[ORM\Column(length: 5)]
    private ?string $order_number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection<int, ProductsOrders>
     */
    #[ORM\OneToMany(targetEntity: ProductsOrders::class, mappedBy: 'order', orphanRemoval: true)]
    private Collection $productsOrders;

    public function __construct()
    {
        $this->productsOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
   

    public function getOrderNumber(): ?string
    {
        return $this->order_number;
    }

    public function setOrderNumber(string $order_number): static
    {
        $this->order_number = $order_number;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, ProductsOrders>
     */
    public function getProductsOrders(): Collection
    {
        return $this->productsOrders;
    }

    public function addProductsOrder(ProductsOrders $productsOrder): static
    {
        if (!$this->productsOrders->contains($productsOrder)) {
            $this->productsOrders->add($productsOrder);
            $productsOrder->setOrder($this);
        }

        return $this;
    }

    public function removeProductsOrder(ProductsOrders $productsOrder): static
    {
        if ($this->productsOrders->removeElement($productsOrder)) {
            // set the owning side to null (unless already changed)
            if ($productsOrder->getOrder() === $this) {
                $productsOrder->setOrder(null);
            }
        }

        return $this;
    }
}

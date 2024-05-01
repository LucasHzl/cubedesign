<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Assert\Length(
        min: 3,
        max: 64,
        minMessage: 'Le titre du produit doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Le titre du produit doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\'\s]+$/i',
        htmlPattern: '^[a-zA-Z0-9\'\s]+$'
    )]
    
    private ?string $title = null;

    #[ORM\Column(length: 256)]
    #[Assert\Length(
        min: 1,
        max: 256,
        minMessage: 'La description du produit doit faire au minimum {{ limit }} caractères',
        maxMessage: 'La description du produit doit faire au maximum {{ limit }} caractères',
    )]

    private ?string $description = null;

    #[ORM\Column]

    #[Assert\PositiveOrZero]
    private ?float $price = null;

    #[ORM\Column]
   
    #[Assert\Regex(
        pattern: '/^[0-9]+$/i',
        htmlPattern: '^[0-9]+$'
    )]
    private ?int $stock = null;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\ManyToMany(targetEntity: Orders::class, inversedBy: 'products')]
    private Collection $relation_products_orders;


    #[ORM\ManyToOne(inversedBy: 'relation_categories_products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $cart;

    public function __construct()
    {
        $this->relation_products_orders = new ArrayCollection();
        $this->cart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getRelationProductsOrders(): Collection
    {
        return $this->relation_products_orders;
    }

    public function addRelationProductsOrder(Orders $relationProductsOrder): static
    {
        if (!$this->relation_products_orders->contains($relationProductsOrder)) {
            $this->relation_products_orders->add($relationProductsOrder);
        }

        return $this;
    }

    public function removeRelationProductsOrder(Orders $relationProductsOrder): static
    {
        $this->relation_products_orders->removeElement($relationProductsOrder);

        return $this;
    }


    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->cart->contains($cart)) {
            $this->cart->add($cart);
            $cart->setRelationCartProducts($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->cart->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getRelationCartProducts() === $this) {
                $cart->setRelationCartProducts(null);
            }
        }

        return $this;
    }
}

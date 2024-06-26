<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 64)]
    private ?string $title = null;
    #[Assert\Length(
        min: 3,
        max: 64,
        minMessage: 'Le titre de la catégorie doit faire au minimum {{ limit }} caractères',
        maxMessage: 'Le titre de la catégorie doit faire au maximum {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/i',
        htmlPattern: '^[a-zA-Z]+$'
    )]
    

    /**
     * @var Collection<int, Products>
     */
    #[ORM\OneToMany(targetEntity: Products::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $relation_categories_products;

    public function __construct()
    {
        $this->relation_categories_products = new ArrayCollection();
    }

    public function __toString() {
        return $this->title;
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

    /**
     * @return Collection<int, Products>
     */
    public function getRelationCategoriesProducts(): Collection
    {
        return $this->relation_categories_products;
    }

    public function addRelationCategoriesProduct(Products $relationCategoriesProduct): static
    {
        if (!$this->relation_categories_products->contains($relationCategoriesProduct)) {
            $this->relation_categories_products->add($relationCategoriesProduct);
            $relationCategoriesProduct->setCategory($this);
        }

        return $this;
    }

    public function removeRelationCategoriesProduct(Products $relationCategoriesProduct): static
    {
        if ($this->relation_categories_products->removeElement($relationCategoriesProduct)) {
            // set the owning side to null (unless already changed)
            if ($relationCategoriesProduct->getCategory() === $this) {
                $relationCategoriesProduct->setCategory(null);
            }
        }

        return $this;
    }
}

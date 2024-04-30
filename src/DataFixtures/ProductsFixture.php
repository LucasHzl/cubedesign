<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProductsFixture extends AbstractFixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            CategoriesFixture::class
        ];
    }


    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++) {

            $product = new Products();
            $product->setTitle($this->faker->words(2, true));
            $product->setDescription($this->faker->word());
            $product->setPrice($this->faker->randomFloat(1, 80, 130));
            $product->setStock($this->faker->randomDigitNotNull());
            $product->setCategory($this->getReference("category_" . $this->faker->numberBetween(0, 4)));
            $this->setReference('product_' . $i, $product);

            $manager->persist($product);
        }
        $manager->flush();
    }
}
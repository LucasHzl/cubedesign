<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class OrdersFixture extends AbstractFixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [
            UsersFixture::class,
            ProductsFixture::class
        ];
    }


    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i ++) {
            $order = new Orders();
            $order->setUser($this->getReference('user_' . $this->faker->numberBetween(0, 4)));
            $order->setOrderNumber($this->faker->randomNumber(5, true));
            $order->setDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $manager->persist($order);
        }
        $manager->flush();
    }
}











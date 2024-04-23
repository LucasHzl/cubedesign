<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;


class ProductFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i ++) {

            $user = new Users();
            $user->setFirstName($this->faker->word());
            $user->setLastName($this->faker->word());
            $user->setEmail($this->faker->word());
            $user->setPassword($this->faker->word());
            $user->setRoles($this->faker->word());


            $manager->persist($user);
}
        $manager->flush();
} 
}
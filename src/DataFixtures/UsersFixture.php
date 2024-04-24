<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixture extends AbstractFixture
{


        public function load(ObjectManager $manager)
        {

            for ($i = 0; $i < 10; $i ++) {

                $user = new Users();
                $user->setFirstName($this->faker->name());
                $user->setLastName($this->faker->name());
                $user->setEmail($this->faker->email());
                $user->setRoles(['ROLE_USER']);

                $user->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        $this->faker->password()
                    )
                );

                $manager->persist($user);
    }
            $manager->flush();
} 
}
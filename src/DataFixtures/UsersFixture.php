<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;


class UsersFixture extends AbstractFixture
{
        public function load(ObjectManager $manager)
        {

            $adminUser = new Users();
            $adminUser->setEmail('lucas@gmail.com   ');
            $adminUser->setRoles(['ROLE_ADMIN']);
            $adminUser->setFirstName('lucas');
            $adminUser->setLastName('lucas');
            $adminUser->setPassword('$2y$13$odE/cGbgYHTi5eon8mULCeL4bNtn17nn4y.K/b8rM5KwfTGqYo3Ee');
            $manager->persist($adminUser);

            for ($i = 0; $i < 10; $i ++) {

                $user = new Users();
                $user->setFirstName($this->faker->firstName());
                $user->setLastName($this->faker->lastName());
                $user->setEmail($this->faker->email());
                $user->setRoles(['ROLE_USER']);

                $user->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        $this->faker->password()
                    )
                );

                $this->setReference('user_' . $i, $user);

                $manager->persist($user);
    }
            $manager->flush();
} 
}
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function ($i){
            $user = new User();
            $user->setEmail(sprintf('user%d@bookwoorm.com', $i));
            $user->setFirstName($this->faker->firstName);
            $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$YmXa/Nguc52KiFninqJz+g$jLn2YEklcRLfMQng7x2wmggy4BmvDqN+BiGme+4H86E');

            return $user;
        });

        $manager->flush();
    }
}

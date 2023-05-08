<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=10;++$i){
            $user = new User();
            $user->setEmail("email".$i."@etu.u-paris.fr");
            $user->setName("name".$i);
            $user->setLastname("lastName".$i);
            $user->setPhoneNumber("phoneNumber".$i);

            $user->setPassword($this->passwordHasher->hashPassword(
                $user,"password".$i
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

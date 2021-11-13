<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Add 1 basic User
        $user = new User();
        $user->setEmail('foo@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
        ));
        $user->setIsVerified(true);

        $manager->persist($user);

        // Add 1 administator User
        $admin = new User();
        $admin->setEmail('bar@ecommerce.com');
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->passwordHasher->hashPassword(
            $admin,
            '123456'
        ));
        $admin->setIsVerified(true);

        $manager->persist($admin);

        $manager->flush();
    }
}

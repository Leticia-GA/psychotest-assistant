<?php

namespace App\DataFixtures;

use App\Entity\Test;
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
        $this->adminFixtures($manager);
        $this->testFixtures($manager);
    }

    public function adminFixtures(ObjectManager $manager): void {
        $admin = new User('admin@gmail.com', [User::ROLE_USER, User::ROLE_ADMIN]);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );

        $admin
            ->setName('Leticia')
            ->setSurnames('González Álvarez')
            ->setPassword($hashedPassword)
        ;

        $manager->persist($admin);

        $manager->flush();
    }

    public function testFixtures(ObjectManager $manager): void {
        for ($i = 1; $i < 6; $i++) {
            $manager->persist(
                new Test('Test de Prueba '.$i)
            );
        }

        $manager->flush();
    }
}

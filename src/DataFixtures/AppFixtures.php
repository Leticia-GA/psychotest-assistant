<?php

namespace App\DataFixtures;

use App\Entity\AssociatedTest;
use App\Entity\Patient;
use App\Entity\Psychologist;
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
        $patient = $this->patientFixtures($manager);
        $this->testFixtures($manager, $patient);
        $this->psychoFixtures($manager);
    }

    public function adminFixtures(ObjectManager $manager): void {
        $admin = new User('Leticia', 'González Álvarez', 'admin@gmail.com', [User::ROLE_USER, User::ROLE_ADMIN]);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );

        $admin->setPassword($hashedPassword);

        $manager->persist($admin);

        $manager->flush();
    }

    public function psychoFixtures(ObjectManager $manager): void {
        $psycho = new Psychologist(
            'Psicólogo 1',
            'Apellidos 1',
            'psico1@gmail.com',
            '699124578',
            'Licenciatura en Psicología',
            'Terapia Sistémica',
            'O-1111'
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho,
            'psico1'
        );

        $psycho->setPassword($hashedPassword);

        $manager->persist($psycho);

        $manager->flush();
    }

    public function patientFixtures(ObjectManager $manager): Patient {
        $patient = new Patient(
            'Paciente 1',
            'Apellidos 1',
            'paciente1@gmail.com',
            '699124578'
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient,
            'pac1'
        );

        $patient->setPassword($hashedPassword);

        $manager->persist($patient);

        $manager->flush();

        return $patient;
    }

    public function testFixtures(ObjectManager $manager, Patient $patient): void {
        for ($i = 1; $i < 6; $i++) {
            $test = new Test('Test de Prueba '.$i);
            $associatedTest = new AssociatedTest($patient, $test);

            $manager->persist($test);
            $manager->persist($associatedTest);
        }

        $manager->flush();
    }
}

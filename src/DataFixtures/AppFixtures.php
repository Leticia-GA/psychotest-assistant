<?php

namespace App\DataFixtures;

use App\Entity\AssociatedTest;
use App\Entity\Patient;
use App\Entity\Psychologist;
use App\Entity\Test;
use App\Entity\User;
use App\Form\Type\PsychologistType;
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
        $this->psychoFixtures($manager, "2");
        $psychologist = $this->psychoFixtures($manager, "1");
        $patient = $this->patientFixtures($manager, $psychologist);
        $this->testFixtures($manager, $patient);
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

    public function psychoFixtures(ObjectManager $manager, string $index): Psychologist {
        $psycho = new Psychologist(
            'Psicólogo '.$index,
            'Apellidos '.$index,
            'psico'.$index.'@gmail.com',
            '69900000'.$index,
            'Licenciatura en Psicología',
            'Terapia Sistémica',
            'O-000'.$index
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho,
            'psico'.$index
        );

        $psycho->setPassword($hashedPassword);

        $manager->persist($psycho);

        $manager->flush();

        return $psycho;
    }

    public function patientFixtures(ObjectManager $manager, Psychologist $psychologist): Patient {
        $patient = new Patient(
            'Paciente 1',
            'Apellidos 1',
            'paciente1@gmail.com',
            '699124578'
        );

        $patient->setPsychologist($psychologist);

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

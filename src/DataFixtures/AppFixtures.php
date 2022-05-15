<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\AssociatedTest;
use App\Entity\Patient;
use App\Entity\Psychologist;
use App\Entity\Question;
use App\Entity\Test;
use App\Entity\TestInterpretation;
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
        $psychologist1 = $this->psychoFixtures($manager, "1");
        $psychologist2 = $this->psychoFixtures($manager, "2");
        $patient1 = $this->patientFixtures($manager, $psychologist1, "1");
        $this->patientFixtures($manager, $psychologist2, "2");
        $this->testFixtures($manager, $patient1);
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
            'Psicólogo'.$index,
            'Apellidos'.$index,
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

    public function patientFixtures(ObjectManager $manager, Psychologist $psychologist, string $index): Patient {
        $patient = new Patient(
            'Paciente'.$index,
            'Apellidos'.$index,
            'paciente'.$index.'@gmail.com',
            '69912457'.$index
        );

        $patient->setPsychologist($psychologist);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient,
            'pac'.$index
        );

        $patient->setPassword($hashedPassword);

        $manager->persist($patient);

        $manager->flush();

        return $patient;
    }

    public function testFixtures(ObjectManager $manager, Patient $patient): void {
        $testGAD7 = $this->createGAD7($manager);
        
        $manager->persist(new AssociatedTest($patient, $testGAD7));
        $manager->flush();
    }

    private function createGAD7(ObjectManager $manager) {
        $test = new Test(
            'Escala para el Trastorno de Ansiedad Generalizada (GAD-7)',
            'Señale con qué frecuencia ha sufrido los siguientes problemas en los últimos 15 días:'
        );

        $manager->persist(new Answer('Nunca', 0, 1, $test));
        $manager->persist(new Answer('Menos de la mitad de los días', 1, 2, $test));
        $manager->persist(new Answer('Más de la mitad de los días', 2, 3, $test));
        $manager->persist(new Answer('Casi todos los días', 3, 4, $test));

        $manager->persist(new Question('Se ha sentido nervioso, ansioso o muy alterado', 1, $test));
        $manager->persist(new Question('No ha podido dejar de preocuparse', 2, $test));
        $manager->persist(new Question('Se ha preocupado excesivamente por diferentes cosas', 3, $test));
        $manager->persist(new Question('Ha tenido dificultad para relajarse', 4, $test));
        $manager->persist(new Question('Se ha sentido tan intranquilo que no podía estarse quieto', 5, $test));
        $manager->persist(new Question('Se ha irritado o enfadado con facilidad', 6, $test));
        $manager->persist(new Question('Ha sentido miedo, como si fuera a suceder algo terrible', 7, $test));

        $manager->persist(new TestInterpretation(
            0, 6, $test,
            'Una puntuación de 5 o menor en el GAD-7 puede interpretarse como un nivel leve de ansiedad.'
        ));

        $manager->persist(new TestInterpretation(
            6, 10, $test,
            'Una puntuación de entre 6 y 10 en el GAD-7 puede interpretarse como un nivel de ansiedad moderado.'
        ));
        
        $manager->persist(new TestInterpretation(
            10, TestInterpretation::MAX_SCORE, $test,
            'Una puntuación superior a 10 en el GAD-7 puede interpretarse como un nivel de ansiedad alto.'
        ));

        $manager->persist($test);
        
        $manager->flush();

        return $test;
    }

}

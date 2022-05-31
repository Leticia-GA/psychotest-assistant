<?php

namespace App\DataFixtures;

use App\Entity\Test;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Clinic;
use App\Entity\Patient;
use App\Entity\Question;
use App\Entity\Psychologist;
use App\Entity\AssociatedTest;
use App\Entity\TestInterpretation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        $this->clinicFixtures($manager);
        $psychologist1 = $this->psychoFixtures($manager, "1");
        $psychologist2 = $this->psychoFixtures($manager, "2");
        $patient1 = $this->patientFixtures($manager, $psychologist1, "1");
        $this->patientFixtures($manager, $psychologist2, "2");
        $this->testFixtures($manager, $patient1);
    }

    public function adminFixtures(ObjectManager $manager): void {
        $admin = new User('Leticia', 'González Álvarez', '71776104-G', '28/10/1991', '626 40 89 50', 'admin@gmail.com', 'https://i.pravatar.cc/?img=22', [User::ROLE_USER, User::ROLE_ADMIN]);

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
            '71717171-A',
            '21/11/1990',
            '62600000'.$index,
            'psico'.$index.'@gmail.com',
            'https://i.pravatar.cc/?img=16',
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
            '71717171-P',
            '21/11/1983',
            '62600250'.$index,
            'paciente'.$index.'@gmail.com',
            'https://i.pravatar.cc/?img=17',
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

    public function clinicFixtures(ObjectManager $manager): void {
        $clinic = new Clinic(
            'La mayoría de la gente gasta más energía en hablar de los problemas que en tratar de resolverlos. Nosotras te acompañamos en lo segundo.',
            '626 408 950',
            'clinica@gmail.com',
            'Calle Esperanza, Nº6 (33600 Mieres - Asturias)',
            'L-V de 09:00h a 14:30h y de 16:30h a 19:30h'
        );

        $manager->persist($clinic);

        $manager->flush();
    }

    public function testFixtures(ObjectManager $manager, Patient $patient): void {
        $testGAD7 = $this->createGAD7($manager);
        $this->createZarit($manager);
        
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

    private function createZarit(ObjectManager $manager) {
        $test = new Test(
            'Escala de Sobrecarga del Cuidador de Zarit',
            'A continuación se presentan una lista de frases que reflejan cómo se sienten algunas personas cuando cuidan a otra persona. Después de leer cada frase, indique con qué frecuencia se siente Ud. de esa manera, escogiendo entre: NUNCA, CASI NUNCA, A VECES, FRECUENTEMENTE O CASI SIEMPRE. No existen respuestas correctas o incorrectas.
            Señale sólo una respuesta para cada pregunta'
        );

        $manager->persist(new Answer('Nunca', 1, 1, $test));
        $manager->persist(new Answer('Rara vez', 2, 2, $test));
        $manager->persist(new Answer('Algunas veces', 3, 3, $test));
        $manager->persist(new Answer('Bastantes veces', 4, 4, $test));
        $manager->persist(new Answer('Casi siempre', 5, 5, $test));

        $manager->persist(new Question('¿Piensa que su familiar le pide más ayuda de la que realmente necesita?', 1, $test));
        $manager->persist(new Question('¿Piensa que debido al tiempo que dedica a su familiar no tiene suficiente tiempo para usted?', 2, $test));
        $manager->persist(new Question('¿Se siente agobiado por intentar compatibilizar el cuidado de su familiar con otras responsabilidades (trabajo, familia)?', 3, $test));
        $manager->persist(new Question('¿Siente vergüenza por la conducta de su familiar?', 4, $test));
        $manager->persist(new Question('¿Se siente enfadado cuando está cerca de su familiar?', 5, $test));
        $manager->persist(new Question('¿Piensa que el cuidar de su familiar afecta negativamente la relación que usted tiene con otros miembros de su familia?', 6, $test));
        $manager->persist(new Question('¿Tiene miedo por el futuro de su familiar?', 7, $test));
        $manager->persist(new Question('¿Piensa que su familiar depende de usted?', 8, $test));
        $manager->persist(new Question('¿Se siente tenso cuando está cerca de su familiar?', 9, $test));
        $manager->persist(new Question('¿Piensa que su salud ha empeorado debido a tener que cuidar de su familiar?', 10, $test));
        $manager->persist(new Question('¿Piensa que no tiene tanta intimidad como le gustaría debido a tener que cuidar de su familiar?', 11, $test));
        $manager->persist(new Question('¿Piensa que su vida social se ha visto afectada negativamente por tener que cuidar a su familiar?', 12, $test));
        $manager->persist(new Question('¿Se siente incómodo por distanciarse de sus amistades debido a tener que cuidar de su familiar?', 13, $test));
        $manager->persist(new Question('¿Piensa que su familiar le considera a usted la única persona que le puede cuidar?', 14, $test));
        $manager->persist(new Question('¿Piensa que no tiene suficientes ingresos económicos para los gastos de cuidar a su familiar, además de sus otros gastos?', 15, $test));
        $manager->persist(new Question('¿Piensa que no será capaz de cuidar a su familiar por mucho más tiempo?', 16, $test));
        $manager->persist(new Question('¿Siente que ha perdido el control de su vida desde que comenzó la enfermedad de su familiar?', 17, $test));
        $manager->persist(new Question('¿Desearía poder dejar el cuidado de su familiar a otra persona?', 18, $test));
        $manager->persist(new Question('¿Se siente indeciso sobre qué hacer con su familiar?', 19, $test));
        $manager->persist(new Question('¿Piensa que debería hacer más por su familiar?', 20, $test));
        $manager->persist(new Question('¿Piensa que podría cuidar mejor a su familiar?', 21, $test));
        $manager->persist(new Question('Globalmente, ¿qué grado de "carga" experimenta por el hecho de cuidar a tu familiar?', 22, $test));

        $manager->persist(new TestInterpretation(
            0, 46, $test,
            'No hay sobrecarga.'
        ));

        $manager->persist(new TestInterpretation(
            46, 56, $test,
            'Sobrecarga leve.'
        ));
        
        $manager->persist(new TestInterpretation(
            56, TestInterpretation::MAX_SCORE, $test,
            'Sobrecarga intensa.'
        ));

        $manager->persist($test);
        
        $manager->flush();

        return $test;
    }

}

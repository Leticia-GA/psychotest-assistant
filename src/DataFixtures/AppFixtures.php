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
use Symfony\Component\Validator\Constraints\Date;

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
        $psycho1 = $this->psycho1Fixtures($manager);
        $this->patientsPsycho1Fixtures($manager, $psycho1);
        $this->psycho2Fixtures($manager);
        $this->testFixtures($manager);
        /*
        $psychologist1 = $this->psychoFixtures($manager, "1");
        $psychologist2 = $this->psychoFixtures($manager, "2");
        $patient1 = $this->patientFixtures($manager, $psychologist1, "1");
        $this->patientFixtures($manager, $psychologist2, "2");
        $this->testFixtures($manager, $patient1);
        */
    }

    public function adminFixtures(ObjectManager $manager): void {
        $admin = new User(
            'Leticia', 
            'González Álvarez', 
            '71776104-G', 
            new \DateTime('12/10/2008'),
            '626 40 89 50', 
            'admin@gmail.com', 
            'https://i.pravatar.cc/?img=22', 
            [User::ROLE_USER, User::ROLE_ADMIN]
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );

        $admin->setPassword($hashedPassword);

        $manager->persist($admin);

        $manager->flush();
    }

    public function psycho1Fixtures(ObjectManager $manager): Psychologist {
        $psycho1 = new Psychologist(
            'Eulogio',
            'Solís Cano',
            '65656415-E',
            new \DateTime('3/9/1979'),
            '626 560 521',
            'eulogio@gmail.com',
            'https://i.pravatar.cc/?img=60',
            'Licenciatura en Psicología',
            'Terapia Cognitivo Conductual',
            'M-6248'
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho1,
            'psico'
        );

        $psycho1->setPassword($hashedPassword);

        $manager->persist($psycho1);

        $manager->flush();

        return $psycho1;
    }

    public function patientsPsycho1Fixtures(ObjectManager $manager, Psychologist $psycho1) {
        $patient1 = new Patient(
            'Hortensio',
            'Prado Rentería',
            '71717171-H',
            new \DateTime('2/17/1969'),
            '612 110 804',
            'hortensio@gmail.com',
            'https://i.pravatar.cc/?img=18',
        );

        $patient2 = new Patient(
            'Margarita',
            'Valdés Reinoso',
            '93939393-M',
            new \DateTime('3/2/1986'),
            '652 267 878',
            'margarita@gmail.com',
            'https://i.pravatar.cc/?img=10',
        );

        $patient3 = new Patient(
            'Gabino',
            'Fonseca Cano',
            '82828282-G',
            new \DateTime('12/2/1988'),
            '642 457 601',
            'gabino@gmail.com',
            'https://i.pravatar.cc/?img=11',
        );

        $patient4 = new Patient(
            'Teodora',
            'Granados Sánchez',
            '64646464-T',
            new \DateTime('9/9/1959'),
            '652 267 878',
            'teodora@gmail.com',
            'https://i.pravatar.cc/?img=21',
        );

        $patient1->setPsychologist($psycho1);
        $patient2->setPsychologist($psycho1);
        $patient3->setPsychologist($psycho1);
        $patient4->setPsychologist($psycho1);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient1,
            'paciente'
        );
        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient2,
            'paciente'
        );
        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient3,
            'paciente'
        );
        $hashedPassword = $this->passwordHasher->hashPassword(
            $patient4,
            'paciente'
        );

        $patient1->setPassword($hashedPassword);
        $patient2->setPassword($hashedPassword);
        $patient3->setPassword($hashedPassword);
        $patient4->setPassword($hashedPassword);

        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);
        $manager->persist($patient4);

        $manager->flush();
    }

    public function psycho2Fixtures(ObjectManager $manager) {
        $psycho2 = new Psychologist(
            'Fortunata',
            'Arriaga Brito',
            '84895484-F',
            new \DateTime('1/4/1995'),
            '695 211 181',
            'fortunata@gmail.com',
            'https://i.pravatar.cc/?img=44',
            'Licenciatura en Psicología',
            'Terapia Sistémica',
            'O-4508'
        );

        $psycho3 = new Psychologist(
            'Julián',
            'Cisneros Quintana',
            '54815151-J',
            new \DateTime('12/9/1979'),
            '662 487 274',
            'julian@gmail.com',
            'https://i.pravatar.cc/?img=8',
            'Licenciatura en Psicopedagogía',
            'Terapia de Aceptación y Compromiso',
            'O-6321'
        );

        $psycho4 = new Psychologist(
            'Úrsula',
            'Muro Madrid',
            '43456343-U',
            new \DateTime('2/5/1994'),
            '695 211 181',
            'ursula@gmail.com',
            'https://i.pravatar.cc/?img=5',
            'Licenciatura en Psicología',
            'Terapia Cognitivo Conductual',
            'O-7431'
        );

        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho2,
            'psico'
        );
        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho3,
            'psico'
        );
        $hashedPassword = $this->passwordHasher->hashPassword(
            $psycho4,
            'psico'
        );

        $psycho2->setPassword($hashedPassword);
        $psycho3->setPassword($hashedPassword);
        $psycho4->setPassword($hashedPassword);

        $manager->persist($psycho2);
        $manager->persist($psycho3);
        $manager->persist($psycho4);

        $manager->flush();
    }


    /*public function psychoFixtures(ObjectManager $manager, string $index): Psychologist {
        
        $psycho = new Psychologist(
            'Psicólogo'.$index,
            'Apellidos'.$index,
            '71717171-A',
            new \DateTime('12/10/2008'),
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
            new \DateTime('12/10/2008'),
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
    }*/

    public function clinicFixtures(ObjectManager $manager): void {
        $clinic = new Clinic(
            1,
            'La mayoría de la gente gasta más energía en hablar de los problemas que en tratar de resolverlos. Nosotr@s te acompañamos en lo segundo.',
            '626 408 950',
            'clinica@gmail.com',
            'Calle Frai Paulino Álvarez (33600 Mieres, Asturias)',
            'L-V de 09:00h a 14:30h y de 16:30h a 19:30h'
        );

        $manager->persist($clinic);

        $manager->flush();
    }

    public function testFixtures(ObjectManager $manager): void {
        // $testGAD7 = $this->createGAD7($manager);
        $this->createGAD7($manager);
        $this->createZarit($manager);
        $this->createGoldbergDepressionSubescale($manager);
        $this->createGoldbergAnxietySubescale($manager);
        
        // $manager->persist(new AssociatedTest($patient, $testGAD7));
        $manager->flush();
    }

    private function createGAD7(ObjectManager $manager) {
        $test = new Test(
            'Escala para el Trastorno de Ansiedad Generalizada (GAD-7)',
            'Señale con qué frecuencia ha sufrido los siguientes problemas en los últimos 15 días:',
            'R.L. Spitzer; K. Kroenke; J.B.W Williams; B. Löwe.',
            '5-10 minutos.',
            'Adultos.',
            'Instrumento creado para servir de screening en el Trastorno de Ansiedad eneralizada. Está compuesto por 7 ítems de respuesta tipo Likert de 0 a 3 que incluyen los síntomas y la discapacidad asociada al trastorno.
            Para su corrección se obtiene una puntuación total de la suma de puntuaciones de todos los ítems, que puede oscilar entre 0 y 21.
            No existen puntos de corte establecidos para la versión española. En la versión original, los autores proponen un punto de corte de mayor o igual a 10.'
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
            Señale sólo una respuesta para cada pregunta.',
            'S.H. Zarit, K.E. Bach-Peterson.',
            '10-20 minutos.',
            'Adultos.',
            'Cuestionario autoadministrado para población cuidadora de personas dependientes.'
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

    private function createGoldbergDepressionSubescale(ObjectManager $manager) {
        $test = new Test(
            'Subescala de Depresión de Goldberg',
            'Reflexione sobre si durante las dos últimas semanas se han presentado algunos de los síntomas que se citan a continuación.',
            'Goldberg y cols.',
            '5-10 minutos.',
            'Adolescentes y Adultos.',
            'La subescala de depresión detecta el 82% de los casos de depresión con el punto de corte en más de 3 preguntas respondidas de forma afirmativa.'
        );

        $manager->persist(new Answer('Sí', 1, 1, $test));
        $manager->persist(new Answer('No', 0, 2, $test));

        $manager->persist(new Question('¿Se ha sentido con poca energía?', 1, $test));
        $manager->persist(new Question('¿Ha perdido usted su interés por las cosas?', 2, $test));
        $manager->persist(new Question('¿Ha perdido la confianza en sí mismo?', 3, $test));
        $manager->persist(new Question('¿Se ha sentido usted desesperanzado, sin esperanzas?', 4, $test));
        $manager->persist(new Question('¿Ha tenido dificultades para concentrarse?', 5, $test));
        $manager->persist(new Question('¿Ha perdido peso? (a causa de su falta de apetito)', 6, $test));
        $manager->persist(new Question('¿Se ha estado despertando demasiado temprano?', 7, $test));
        $manager->persist(new Question('¿Se ha sentido usted enlentecido?', 8, $test));
        $manager->persist(new Question('¿Cree usted que ha tenido tendencia a encontrarse peor por las mañanas?', 9, $test));

        $manager->persist(new TestInterpretation(
            0, 3, $test,
            'No existe riesgo de depresión.'
        ));
        
        $manager->persist(new TestInterpretation(
            3, TestInterpretation::MAX_SCORE, $test,
            'Posible riesgo de depresión (evaluar más en profundidad).'
        ));

        $manager->persist($test);
        
        $manager->flush();

        return $test;
    }

    private function createGoldbergAnxietySubescale(ObjectManager $manager) {
        $test = new Test(
            'Subescala de Ansiedad de Goldberg',
            'Reflexione sobre si durante las dos últimas semanas se han presentado algunos de los síntomas que se citan a continuación.',
            'Goldberg y cols.',
            '5-10 minutos.',
            'Adolescentes y Adultos.',
            'La subescala de ansiedad detecta el 73% de los casos de ansiedad con el punto de corte en más de 3 preguntas respondidas de forma afirmativa.'
        );

        $manager->persist(new Answer('Sí', 1, 1, $test));
        $manager->persist(new Answer('No', 0, 2, $test));

        $manager->persist(new Question('¿Se ha sentido muy excitado, nervioso o en tensión?', 1, $test));
        $manager->persist(new Question('¿Ha estado muy preocupado por algo?', 2, $test));
        $manager->persist(new Question('¿Se ha sentido muy irritable?', 3, $test));
        $manager->persist(new Question('¿Ha tenido dificultad para relajarse?', 4, $test));
        $manager->persist(new Question('¿Ha dormido mal, ha tenido dificultades para dormir?', 5, $test));
        $manager->persist(new Question('¿Ha tenido dolores de cabeza o nuca?', 6, $test));
        $manager->persist(new Question('¿Ha tenido alguno de los siguientes síntomas: temblores, hormigueos, mareos, sudores, diarrea?', 7, $test));
        $manager->persist(new Question('¿Ha estado preocupado por su salud?', 8, $test));
        $manager->persist(new Question('¿Ha tenido alguna dificultad para conciliar el sueño, para quedarse dormido?', 9, $test));

        $manager->persist(new TestInterpretation(
            0, 4, $test,
            'No existe riesgo de ansiedad.'
        ));
        
        $manager->persist(new TestInterpretation(
            4, TestInterpretation::MAX_SCORE, $test,
            'Posible riesgo de ansiedad (evaluar más en profundidad).'
        ));

        $manager->persist($test);
        
        $manager->flush();

        return $test;
    }

}

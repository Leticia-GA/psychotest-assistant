<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $patient1 = new Patient('Pepito', 'Grillo', '626531589', 'pepitogrillo@gmail.com');
        $patient2 = new Patient('Jaimito', 'García', '6551654891', 'jaimitin@gmail.com');
        $patient3 = new Patient('María', 'Domínguez', '9854216957', 'maridomi@hotmail.com');

        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);

        $manager->flush();
    }
}

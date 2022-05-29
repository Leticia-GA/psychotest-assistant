<?php

namespace App\Repository;

use App\Entity\TestDone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TestDoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestDone::class);
    }

    public function findAllTestDone(int $psychoId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT td 
             FROM App\Entity\TestDone td
             JOIN td.associatedTest associatedTest
             JOIN associatedTest.patient p
             WHERE p.psychologist = :psychoId
             ORDER BY td.date DESC' 
        )->setParameter('psychoId', $psychoId);

        return $query->getResult();
    }

    public function findAllNoReadTestDone(int $psychoId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT td 
             FROM App\Entity\TestDone td
             JOIN td.associatedTest associatedTest
             JOIN associatedTest.patient p
             WHERE p.psychologist = :psychoId AND td.readAt IS NULL
             ORDER BY td.date DESC' 
        )->setParameter('psychoId', $psychoId);

        return $query->getResult();
    }

    public function findTestDoneByPsychologist(int $id, int $psychoId): ?TestDone
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT td 
             FROM App\Entity\TestDone td
             JOIN td.associatedTest associatedTest
             JOIN associatedTest.patient p
             WHERE td.id = :id AND p.psychologist = :psychoId
             ORDER BY td.date DESC'
        )->setParameters([
            'id' => $id,
            'psychoId' => $psychoId
        ]);

        return $query->getOneOrNullResult();
    }

    public function findTestDoneByPatient(int $patientId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT td 
             FROM App\Entity\TestDone td
             JOIN td.associatedTest associatedTest
             JOIN associatedTest.patient p
             WHERE p.id = :patientId
             ORDER BY td.date DESC' 
        )->setParameters([
            'patientId' => $patientId
        ]);

        return $query->getResult();
    }
}
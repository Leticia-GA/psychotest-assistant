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
}
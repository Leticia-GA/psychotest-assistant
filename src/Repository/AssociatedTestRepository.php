<?php

namespace App\Repository;

use App\Entity\AssociatedTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AssociatedTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssociatedTest::class);
    }

    public function findAllPendingTest(int $patientId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT associatedTest 
             FROM App\Entity\AssociatedTest associatedTest
             LEFT JOIN App\Entity\TestDone testDone WITH associatedTest.id = testDone.associatedTest
             WHERE associatedTest.patient = :patientId
             AND testDone.associatedTest IS NULL
             ORDER BY associatedTest.date DESC' 
        )->setParameter('patientId', $patientId);

        return $query->getResult();
    }
}
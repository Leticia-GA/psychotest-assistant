<?php

namespace App\Repository;

use App\Entity\TestInterpretation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TestInterpretationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestInterpretation::class);
    }

    public function findInterpretationByScore(int $score): TestInterpretation
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ti 
             FROM App\Entity\TestInterpretation ti
             WHERE :score >= ti.min AND :score < ti.max' 
        )->setParameter('score', $score);

        return $query->getSingleResult();
    }

}
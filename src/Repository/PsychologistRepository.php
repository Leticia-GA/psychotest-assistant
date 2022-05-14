<?php

namespace App\Repository;

use App\Entity\Psychologist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PsychologistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Psychologist::class);
    }

    public function findAllPatients(int $psychologistId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT patient 
             FROM App\Entity\Patient patient
             WHERE patient.psychologist = :psychologistId' 
        )->setParameter('psychologistId', $psychologistId);

        return $query->getResult();
    }
}
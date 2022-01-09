<?php

namespace App\Controller;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patients")
     */
    public function patients(): Response
    {
        $repository = $this->entityManager->getRepository(Patient::class);
        $patients = $repository->findAll();

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }
}
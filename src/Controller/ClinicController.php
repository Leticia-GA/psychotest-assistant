<?php

namespace App\Controller;

use App\Entity\Clinic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClinicController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/clinic", name="clinic")
     */
    public function clinic(): Response
    {
        $repository = $this->entityManager->getRepository(Clinic::class);

        $clinic = $repository->find(1);

        return $this->render('clinic/clinic.html.twig', ['clinic' => $clinic]);
    }

}
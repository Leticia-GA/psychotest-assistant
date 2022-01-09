<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\Type\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/patients/new")
     */
    public function new(Request $request): Response
    {
        $patient = new Patient('', '', '', '');
        $form = $this->createForm(PatientType::class, $patient);

        return $this->renderForm('patients/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
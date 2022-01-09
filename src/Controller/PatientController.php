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
     * @Route("/patients", name="patients_list")
     */
    public function patients(): Response
    {
        $repository = $this->entityManager->getRepository(Patient::class);
        $patients = $repository->findAll();

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/patients/new", name="new_patient")
     */
    public function new(Request $request): Response
    {
        $patient = new Patient('', '', '', '');
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();

            $this->entityManager->persist($patient);
            $this->entityManager->flush();

            return $this->redirectToRoute('patients_list');
        }

        return $this->renderForm('patients/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
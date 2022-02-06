<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Form\Type\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function patients(): Response
    {
        $repository = $this->entityManager->getRepository(Patient::class);
        $patients = $repository->findAll();

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/patients/new", name="new_patient")
     * @IsGranted(User::ROLE_PSYC)
     */
    public function new(UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $patient = new Patient('', '', '', '');
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $patient,
                $patient->getPassword()
            );

            $patient->setPassword($hashedPassword);
            $patient->setRoles([User::ROLE_USER]);

            $this->entityManager->persist($patient);
            $this->entityManager->flush();

            return $this->redirectToRoute('patients_list');
        }

        return $this->renderForm('patients/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
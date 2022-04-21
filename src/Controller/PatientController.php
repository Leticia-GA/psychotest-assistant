<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Patient;
use App\Form\Type\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
     * @Route("/patient/{id}", name="patient_details", requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function patient(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Patient::class);
        $patient = $repository->find($id);

        if(!$patient) {
            throw new NotFoundHttpException();
        }

        return $this->render('patients/details.html.twig', ['patient' => $patient]);
    }

    /**
     * @Route("/patient/{id}", name="patient_update", requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function update(int $id): Response
    {
        $repository = $this->entityManager->getRepository(patient::class);
        $patients = $repository->findAll();

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/patient/{id}", name="patient_remove", requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function remove(int $id): Response
    {
        $repository = $this->entityManager->getRepository(patient::class);
        $patients = $repository->findAll();

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/patients/create", name="patient_create")
     * @IsGranted(User::ROLE_PSYC)
     */
    public function create(UserPasswordHasherInterface $passwordHasher, Request $request): Response
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
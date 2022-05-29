<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Patient;
use App\Entity\TestDone;
use App\Form\Type\PatientType;
use App\Form\Type\PatientEditType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security as SecurityService;
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
    public function patients(SecurityService $security): Response
    {
        $user = $security->getUser();
        $userRoles = $user->getRoles();
        $repository = $this->entityManager->getRepository(Patient::class);

        $patients = [];

        if(in_array("ROLE_ADMIN", $userRoles)) {
            $patients = $repository->findAll();
        }

        if(in_array("ROLE_PSYC", $userRoles)) {
            $patients = $repository->findBy(["psychologist" => $user->getId()]);
        }

        return $this->render('patients/list.html.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/patient/{id}", name="patient_details", requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function patient(int $id, SecurityService $security): Response
    {
        $user = $security->getUser();
        $userRoles = $user->getRoles();
        $repository = $this->entityManager->getRepository(Patient::class);

        if(in_array("ROLE_ADMIN", $userRoles)) {
            $patient = $repository->find($id);
        }

        if(in_array("ROLE_PSYC", $userRoles)) {
            $patient = $repository->findOneBy([
                "id" => $id, 
                "psychologist" => $user->getId()
            ]);
        }

        if(!$patient) {
            throw new NotFoundHttpException();
        }

        $patientTestDone = [];
        
        if(in_array("ROLE_PSYC", $userRoles) || in_array("ROLE_ADMIN", $userRoles) ) {
            $testDoneRepository = $this->entityManager->getRepository(TestDone::class);

            $patientTestDone = $testDoneRepository->findTestDoneByPatient($patient->getId());
        }

        return $this->render('patients/details.html.twig', [
            'patient' => $patient,
            'psychologist' => $patient->getPsychologist(),
            'test_done' => $patientTestDone
        ]);
    }

    /**
     * @Route("/patient/{id}/update", name="patient_update", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_PSYC)
     */
    public function update(int $id, UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $repository = $this->entityManager->getRepository(Patient::class);
        $patient = $repository->find($id);

        if (!$patient) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(PatientEditType::class, $patient);
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

            $this->addFlash(
                'notice',
                'Cambios guardados correctamente!'
            );

            return $this->redirectToRoute('patients_list');
        }

        return $this->renderForm('patients/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/patient_remove/{id}", name="patient_remove", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_PSYC)
     */
    public function remove(int $id, SecurityService $security): Response
    {
        $user = $security->getUser();
        $userRoles = $user->getRoles();
        $repository = $this->entityManager->getRepository(Patient::class);

        if(in_array("ROLE_PSYC", $userRoles)) {
            $patient = $repository->findOneBy([
                "id" => $id, 
                "psychologist" => $user->getId()
            ]);
        }

        if(!$patient) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($patient);
        $this->entityManager->flush();

        $this->addFlash(
            'notice',
            'Paciente eliminado correctamente!'
        );

        return $this->redirectToRoute('patients_list');
    }

    /**
     * @Route("/patients/create", name="patient_create")
     * @IsGranted(User::ROLE_PSYC)
     */
    public function create(UserPasswordHasherInterface $passwordHasher, Request $request, SecurityService $security): Response
    {
        $patient = new Patient('', '', '', '');
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();
            $patient = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $patient,
                $patient->getPassword()
            );

            $patient
                ->setPsychologist($user)
                ->setPassword($hashedPassword)
                ->setRoles([User::ROLE_USER])
            ;

            $this->entityManager->persist($patient);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'Paciente creado correctamente!'
            );

            return $this->redirectToRoute('patients_list');
        }

        return $this->renderForm('patients/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
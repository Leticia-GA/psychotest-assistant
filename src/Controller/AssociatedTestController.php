<?php

namespace App\Controller;

use App\Entity\AssociatedTest;
use App\Entity\Patient;
use App\Entity\User;
use App\Entity\Test;
use App\Form\Type\AssociatedTestToPatientType;
use App\Form\Type\AssociatedTestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class AssociatedTestController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patient/{id}/associated_test/create", name="associated_test_create", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_PSYC)
     */
    public function create(int $id, Security $security, Request $request): Response
    {
        $user = $security->getUser();
        $repository = $this->entityManager->getRepository(Patient::class);

        $patient = $repository->findOneBy([
            "id" => $id, 
            "psychologist" => $user->getId()
        ]);

        if(!$patient) {
            throw new NotFoundHttpException();
        }

        $associatedTest = new AssociatedTest($patient);
        $form = $this->createForm(AssociatedTestType::class, $associatedTest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associatedTest = $form->getData();
            
            $this->entityManager->persist($associatedTest);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'Se ha enviado correctamente el test '.$associatedTest->getTest()->getName().' al paciente '.$patient->getName()
            );

            return $this->redirectToRoute('patients_list');
        }

        return $this->render('associated_test/new.html.twig', [
            'form' => $form->createView(), 
            'patient' => $patient
        ]);
    }
    
    /**
     * @Route("/test/{id}/associated_test/create", name="associated_test_associate", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_PSYC)
     */
    public function associate(int $id, Security $security, Request $request): Response
    {
        $user = $security->getUser();
        $repository = $this->entityManager->getRepository(Test::class);

        $test = $repository->find($id);

        if(!$test) {
            throw new NotFoundHttpException();
        }

        $associatedTest = new AssociatedTest(null, $test);
        $form = $this->createForm(AssociatedTestToPatientType::class, $associatedTest, ['psychologist' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associatedTest = $form->getData();
            
            $this->entityManager->persist($associatedTest);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'Se ha enviado correctamente el test '.$associatedTest->getTest()->getName().' al paciente '.$associatedTest->getPatient()->getName()
            );

            return $this->redirectToRoute('patients_list');
        }

        return $this->render('associated_test/newToPatient.html.twig', [
            'form' => $form->createView(), 
            'test' => $test
        ]);
    }
}
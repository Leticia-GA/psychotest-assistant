<?php

namespace App\Controller;

use App\Entity\Psychologist;
use App\Entity\User;
use App\Form\Type\PsychologistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PsychologistController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/psychologists", name="psychologists_list")
     * 
     */
    public function pshychologists(): Response
    {
        $repository = $this->entityManager->getRepository(Psychologist::class);
        $psychologists = $repository->findAll();

        return $this->render('psychologists/list.html.twig', ['psychologists' => $psychologists]);
    }

    /**
     * @Route("/psychologists/new", name="new_psychologist")
     * 
     */
    public function new(UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $psychologist = new Psychologist('', '', '', '', '', '', '');
        $form = $this->createForm(PsychologistType::class, $psychologist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $psychologist = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $psychologist,
                $psychologist->getPassword()
            );

            $psychologist->setPassword($hashedPassword);
            $psychologist->setRoles([User::ROLE_USER]);

            $this->entityManager->persist($psychologist);
            $this->entityManager->flush();

            return $this->redirectToRoute('psychologists_list');
        }

        return $this->renderForm('psychologists/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Psychologist;
use App\Form\Type\PsychologistType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @IsGranted(User::ROLE_ADMIN)
     */
    public function pshychologists(): Response
    {
        $repository = $this->entityManager->getRepository(Psychologist::class);
        $psychologists = $repository->findAll();

        return $this->render('psychologists/list.html.twig', ['psychologists' => $psychologists]);
    }

    /**
     * @Route("/psychologist/{id}", name="psychologist_details", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_ADMIN)
     */
    public function pshychologist(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Psychologist::class);
        $psychologist = $repository->find($id);

        if(!$psychologist) {
            throw new NotFoundHttpException();
        }

        return $this->render('psychologists/details.html.twig', ['psychologist' => $psychologist]);
    }

    /**
     * @Route("/psychologist/{id}", name="psychologist_update", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_ADMIN)
     */
    public function update(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Psychologist::class);
        $psychologists = $repository->findAll();

        return $this->render('psychologists/list.html.twig', ['psychologists' => $psychologists]);
    }

    /**
     * @Route("/psychologist_remove/{id}", name="psychologist_remove", requirements={"id"="\d+"})
     * @IsGranted(User::ROLE_ADMIN)
     */
    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $psychologist = $entityManager->getRepository(Psychologist::class)->find($id);

        if (!$psychologist) {
            throw $this->createNotFoundException(
                'No se ha encontrado ningún Psicólogo para el ID: '.$id
            );
        }

        $entityManager->remove($psychologist);
        $entityManager->flush();

        $psychologists = $this->entityManager->getRepository(Psychologist::class)->findAll();

        return $this->render('psychologists/list.html.twig', ['psychologists' => $psychologists]);
    }

    /**
     * @Route("/psychologists/create", name="psychologist_create")
     * @IsGranted(User::ROLE_ADMIN)
     */
    public function create(UserPasswordHasherInterface $passwordHasher, Request $request): Response
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
            $psychologist->setRoles([User::ROLE_USER, User::ROLE_PSYC]);
            

            $this->entityManager->persist($psychologist);
            $this->entityManager->flush();

            return $this->redirectToRoute('psychologists_list');
        }

        return $this->renderForm('psychologists/new.html.twig', [
            'form' => $form,
        ]);
    }
    
}
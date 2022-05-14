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
use Symfony\Component\Security\Core\Security as SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile/{id}", name="profile", requirements={"id"="\d+"})
     */
    public function user(int $id, SecurityService $security): Response
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

        return $this->render('patients/details.html.twig', [
            'patient' => $patient,
            'psychologist' => $patient->getPsychologist()
        ]);
    }
    
}
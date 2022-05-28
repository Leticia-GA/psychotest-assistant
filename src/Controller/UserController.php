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
     * @Route("/profile", name="profile")
     */
    public function user(SecurityService $security): Response
    {
        $user = $security->getUser();

        if(!$user) {
            throw new NotFoundHttpException();
        }
        
        $userRoles = $user->getRoles();

        if(in_array("ROLE_ADMIN", $userRoles)) {
            return $this->render('admin/profile.html.twig');
        }

        if(in_array("ROLE_PSYC", $userRoles)) {
            return $this->render('psychologists/profile.html.twig');
        }

        return $this->render('patients/profile.html.twig');
    }
    
}
<?php

namespace App\Controller;

use App\Entity\AssociatedTest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController 
{
    /**
     * @Route("/", name="dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function index(Security $security, EntityManagerInterface $entityManager) 
    {
        $user = $security->getUser();
        $userRoles = $user->getRoles();

        if(in_array("ROLE_ADMIN", $userRoles)) {
            return $this->render('dashboard/index.html.twig');
        }

        if(in_array("ROLE_PSYC", $userRoles)) {
            return $this->render('dashboard/index.html.twig');
        }

        $repository = $entityManager->getRepository(AssociatedTest::class);
        $test = $repository->findBy(
            ["patient" => $user->getId()],
            ["date" => 'DESC']
        );

        return $this->render('dashboard/patient/index.html.twig', ['test' => $test]);
    }
}
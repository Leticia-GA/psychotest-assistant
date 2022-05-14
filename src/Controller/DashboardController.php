<?php

namespace App\Controller;

use App\Entity\TestDone;
use App\Entity\AssociatedTest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            $repository = $entityManager->getRepository(TestDone::class);
            $test = $repository->findAllTestDone($user->getId());

            return $this->render('dashboard/psychologist/index.html.twig', ['test' => $test]);
        }

        $repository = $entityManager->getRepository(AssociatedTest::class);
        $test = $repository->findAllPendingTest($user->getId());

        return $this->render('dashboard/patient/index.html.twig', ['test' => $test]);
    }
}
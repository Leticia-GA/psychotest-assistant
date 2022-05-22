<?php

namespace App\Controller;

use App\Entity\TestDone;
use App\Entity\AssociatedTest;
use App\Entity\SortableByDate;
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
            $associatedTestRepository = $entityManager->getRepository(AssociatedTest::class);
            $associatedTest = $associatedTestRepository->findAll();

            $testDoneRepository = $entityManager->getRepository(TestDone::class);
            $testDone = $testDoneRepository->findAll();

            $notifications = array_merge($associatedTest, $testDone);

            usort($notifications, [DashboardController::class, "sortByDate"]);

            return $this->render('dashboard/admin/index.html.twig', ['notifications' => $notifications]);
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

    private function sortByDate(SortableByDate $notification1, SortableByDate $notification2): int {
        if($notification1->getDate() > $notification2->getDate()) {
            return -1;
        } 

        if($notification1->getDate() < $notification2->getDate()) {
            return 1;
        } 

        return 0;
    }
}
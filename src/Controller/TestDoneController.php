<?php

namespace App\Controller;

use App\Entity\AssociatedTest;
use App\Entity\TestDone;
use App\Form\Type\TestDoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class TestDoneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/associated_test/{id}/answer", name="test_done_create", requirements={"id"="\d+"})
     */
    public function create(int $id, Security $security, Request $request): Response
    {
        $user = $security->getUser();
        $repository = $this->entityManager->getRepository(AssociatedTest::class);

        $associatedTest = $repository->findOneBy([
            "id" => $id, 
            "patient" => $user->getId()
        ]);

        if(!$associatedTest) {
            throw new NotFoundHttpException();
        }

        $testDone = new TestDone($associatedTest);
        $form = $this->createForm(TestDoneType::class, $testDone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testDone = $form->getData();
            
            $this->entityManager->persist($testDone);
            $this->entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('test_done/new.html.twig', [
            'form' => $form->createView(),
            'test' => $associatedTest->getTest()
        ]);
    }  
}
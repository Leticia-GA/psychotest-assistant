<?php

namespace App\Controller;

use App\Entity\AssociatedTest;
use App\Entity\TestDone;
use App\Form\Type\TestDoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

use function PHPUnit\Framework\isEmpty;

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

            $testDone->setAnswers($this->getAnswers($form));
            
            $this->entityManager->persist($testDone);
            $this->entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('test_done/new.html.twig', [
            'form' => $form->createView(),
            'test' => $associatedTest->getTest()
        ]);
    }  

    private function getAnswers(FormInterface $form): array {
        $answers = [];

        $i = 0;

        while($form->has("answer".$i)) {
            $answerPosition = $form->get("answer".$i)->getData();
            $answers[] = $answerPosition;
            $i++;
        }

        return $answers;
    }

    /**
     * @Route("/test_done/{id}/review", name="test_done_review", requirements={"id"="\d+"})
     */ 
    public function review(int $id, Security $security): Response {
        $user = $security->getUser();
        $testDoneRepository = $this->entityManager->getRepository(TestDone::class);

        $testDone = $testDoneRepository->findTestDoneByPsychologist($id, $user->getId());

        if(!$testDone) {
            throw new NotFoundHttpException();
        }

        return $this->render('test_done/review.html.twig', ['testDone' => $testDone]);
    }
}
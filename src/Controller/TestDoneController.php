<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Test;
use App\Entity\TestDone;
use App\Entity\AssociatedTest;
use App\Form\Type\TestDoneType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security as SecurityService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    public function create(int $id, SecurityService $security, Request $request): Response
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

            $testDone->setAnswerPositions($this->getAnswerPositions($form));
            
            $this->entityManager->persist($testDone);
            $this->entityManager->flush();

            $this->addFlash(
                'notice',
                'Test realizado correctamente. ¡Muchas gracias!'
            );

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('test_done/new.html.twig', [
            'form' => $form->createView(),
            'test' => $associatedTest->getTest()
        ]);
    }  

    private function getAnswerPositions(FormInterface $form): array {
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */ 
    public function review(int $id, SecurityService $security): Response {
        $user = $security->getUser();
        $testDoneRepository = $this->entityManager->getRepository(TestDone::class);

        $testDone = $testDoneRepository->findTestDoneByPsychologist($id, $user->getId());

        if(!$testDone) {
            throw new NotFoundHttpException();
        }

        $testDone->setReadAt(new DateTime());
        $this->entityManager->persist($testDone);
        $this->entityManager->flush();

        $test = $testDone->getAssociatedTest()->getTest();

        return $this->render('test_done/review.html.twig', [
            'testDone' => $testDone,
            'questions' => $this->getQuestions($test),
            'answers' =>  $this->getAnswers($test)
        ]);
    }

    private function getQuestions(Test $test): array 
    {
        $questionRepository = $this->entityManager->getRepository(Question::class);

        return $questionRepository->findBy(
            ["test" => $test->getId()],
            ["position" => "ASC"]
        );
    }

    private function getAnswers(Test $test): array 
    {
        $answerRepository = $this->entityManager->getRepository(Answer::class);

        return $answerRepository->findBy(
            ["test" => $test->getId()],
            ["position" => "ASC"]
        );
    }

}
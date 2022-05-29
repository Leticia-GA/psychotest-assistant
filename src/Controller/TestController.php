<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TestController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/test", name="test_list")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function test(): Response
    {
        $repository = $this->entityManager->getRepository(Test::class);
        $test = $repository->findAll();

        return $this->render('test/list.html.twig', ['test' => $test]);
    }

    /**
     * @Route("/test/{id}", name="test_details", requirements={"id"="\d+"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PSYC')")
     */
    public function singleTest(int $id): Response
    {
        $repository = $this->entityManager->getRepository(Test::class);
        $test = $repository->find($id);

        if(!$test) {
            throw new NotFoundHttpException();
        }

        return $this->render('test/details.html.twig', [
            'test' => $test,
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
<?php

namespace App\Services;

use App\Entity\Answer;
use App\Entity\Test;
use App\Entity\TestDone;
use App\Entity\TestInterpretation;
use Doctrine\ORM\EntityManagerInterface;

class TestReviewer 
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getScore(TestDone $testDone): int
    {
        $score = 0;

        $testDoneAnswers = $testDone->getAnswerPositions();
        $test = $testDone->getAssociatedTest()->getTest();
        $answers = $this->getAnswers($test);

        foreach($testDoneAnswers as $answerPosition) {
            $score += $this->getAnswerScore($answerPosition, $answers);
        }

        return $score;
    }

    private function getAnswerScore(int $answerPosition, array $answers): int
    {
        foreach($answers as $answer) {
            if($answerPosition == $answer->getPosition()) {
                return $answer->getScore();
            }
        }

        return 0;
    }

    private function getAnswers(Test $test): array 
    {
        $answerRepository = $this->entityManager->getRepository(Answer::class);

        return $answerRepository->findBy(
            ["test" => $test->getId()],
            ["position" => "ASC"]
        );
    }

    public function getInterpretation(TestDone $testDone): string
    {
        $score = $this->getScore($testDone);

        $repository = $this->entityManager->getRepository(TestInterpretation::class);
        $testInterpretation = $repository->findInterpretationByScore($score);

        return $testInterpretation->getText();
    }
}
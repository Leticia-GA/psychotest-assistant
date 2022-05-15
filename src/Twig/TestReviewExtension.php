<?php

namespace App\Twig;

use App\Entity\TestDone;
use App\Services\TestReviewer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TestReviewExtension extends AbstractExtension
{
    private $testReviewer;

    public function __construct(TestReviewer $testReviewer)
    {
        $this->testReviewer = $testReviewer;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('score', [$this, 'getScore']),
        ]; 
    }

    public function getScore(TestDone $testDone): int
    {
        return $this->testReviewer->getScore($testDone);
    }
}
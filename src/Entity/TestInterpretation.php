<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class TestInterpretation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $min;

    /**
     * @ORM\Column(type="smallint")
     */
    private $max;

    /**
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $test;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    public const MAX_SCORE = 9999;

    public function __construct(int $min, int $max, Test $test, string $text)
    {
        $this->min = $min;
        $this->max = $max;
        $this->test = $test;
        $this->text = $text;$this->test = $test;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getTest(): Test
    {
        return $this->test;
    }
 
    public function getText(): string
    {
        return $this->text;
    }

}
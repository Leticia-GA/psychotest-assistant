<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="smallint")
     */
    private $score;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $test;

    public function __construct(string $text, int $score, int $position, Test $test)
    {
        $this->text = $text;
        $this->score = $score;
        $this->position = $position;
        $this->test = $test;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getTest(): Test
    {
        return $this->test;
    }
}
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class Question
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
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $test;

    public function __construct(string $text, int $position, Test $test)
    {
        $this->text = $text;
        $this->position = $position;
        $this->test = $test;
    }

    public function getText(): string
    {
        return $this->text;
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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestDoneRepository")
 */
class TestDone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="AssociatedTest")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $associatedTest;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $answers;

    public function __construct(AssociatedTest $associatedTest)
    {
        $this->date = new \DateTime();
        $this->associatedTest = $associatedTest;
        $this->answers = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): \DateTime {
        return $this->date;
    }

    public function setDate(\DateTime $date): self {
        $this->date = $date;

        return $this;
    }

    public function getAssociatedTest(): AssociatedTest {
        return $this->associatedTest;
    }

    public function setAssociatedTest(AssociatedTest $associatedTest): self {
        $this->associatedTest = $associatedTest;

        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers($answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}
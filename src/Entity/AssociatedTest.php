<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssociatedTestRepository")
 */
class AssociatedTest
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
     * @ORM\ManyToOne(targetEntity="Patient")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $test;

    public function __construct(Patient $patient, ?Test $test = null)
    {
        $this->patient = $patient;
        $this->test = $test;
        $this->date = new \DateTime();
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

    public function getPatient(): Patient {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self {
        $this->patient = $patient;

        return $this;
    }

    public function getTest(): ?Test {
        return $this->test;
    }

    public function setTest(Test $test): self {
        $this->test = $test;

        return $this;
    }
}
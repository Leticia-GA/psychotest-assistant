<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
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

    public function __construct(AssociatedTest $associatedTest)
    {
        $this->date = new \DateTime();
        $this->associatedTest = $associatedTest;
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
}
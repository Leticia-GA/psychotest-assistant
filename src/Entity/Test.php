<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $explanation;

     /**
     * @ORM\Column(type="string", length=200)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $time;

     /**
     * @ORM\Column(type="string", length=100)
     */
    private $applicationAge;

     /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct(string $name, string $explanation, string $author, string $time, string $applicationAge, string $description)
    {
        $this->name = $name;
        $this->explanation = $explanation;
        $this->author = $author;
        $this->time = $time;
        $this->applicationAge = $applicationAge;
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExplanation(): string
    {
        return $this->explanation;
    }
 
    public function getAuthor()
    {
        return $this->author;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getApplicationAge()
    {
        return $this->applicationAge;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->name;
    }
}
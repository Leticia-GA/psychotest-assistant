<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Psychologist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $surnames;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $specialization;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $collegiateNumber;

    public function __construct(string $name, string $surnames, string $phoneNumber, string $email, string $education, string $specialization, string $collegiateNumber)
    {
        $this->name = $name;
        $this->surnames = $surnames;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->education = $education;
        $this->specialization = $specialization;
        $this->collegiateNumber = $collegiateNumber;  
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Psychologist
    {
        $this->name = $name;

        return $this;
    }

    public function getSurnames(): string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): Psychologist
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(string $phoneNumber): Psychologist
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Psychologist
    {
        $this->email = $email;

        return $this;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    public function getSpecialization()
    {
        return $this->specialization;
    }

    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getCollegiateNumber()
    {
        return $this->collegiateNumber;
    }

    public function setCollegiateNumber($collegiateNumber)
    {
        $this->collegiateNumber = $collegiateNumber;

        return $this;
    }
}
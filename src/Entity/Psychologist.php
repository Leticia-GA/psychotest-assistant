<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @UniqueEntity(
 *     fields={"collegiateNumber"},
 *     message="Ya existe un usuario con este Número de Colegiado/a"
 * )
 */
class Psychologist extends User
{
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $specialization;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $collegiateNumber;

    public function __construct(
        string $name, 
        string $surnames, 
        string $email,
        string $phoneNumber, 
        string $education, 
        string $specialization, 
        string $collegiateNumber
    ) {
        parent::__construct($name, $surnames, $email, [User::ROLE_USER, User::ROLE_PSYC]);
        $this->phoneNumber = $phoneNumber;
        $this->education = $education;
        $this->specialization = $specialization;
        $this->collegiateNumber = $collegiateNumber;  
    }

    public function getPhoneNumber(): string 
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEducation($education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getSpecialization()
    {
        return $this->specialization;
    }

    public function setSpecialization($specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getCollegiateNumber()
    {
        return $this->collegiateNumber;
    }

    public function setCollegiateNumber($collegiateNumber): self
    {
        $this->collegiateNumber = $collegiateNumber;

        return $this;
    }
}
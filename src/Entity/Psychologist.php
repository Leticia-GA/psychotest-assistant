<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity()
 * @UniqueEntity(
 *     fields={"collegiateNumber"},
 *     message="Ya existe un usuario con este Número de Colegiado/a"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Ya existe un usuario con el mismo email", 
 *     entityClass="App\Entity\User" 
 * )
 */
class Psychologist extends User
{
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
        string $dni, 
        DateTime $birthDate,
        string $phoneNumber,
        string $email,
        string $photo,
        string $education, 
        string $specialization, 
        string $collegiateNumber
    ) {
        parent::__construct($name, $surnames, $dni, $birthDate, $phoneNumber, $email, $photo, [User::ROLE_USER, User::ROLE_PSYC]);
        $this->education = $education;
        $this->specialization = $specialization;
        $this->collegiateNumber = $collegiateNumber;  
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
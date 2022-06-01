<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Ya existe un usuario con el mismo email", 
 *     entityClass="App\Entity\User" 
 * )
 */
class Patient extends User
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diagnostic;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $caseHistory;

    /**
     * @ORM\ManyToOne(targetEntity="Psychologist")
     */
    private $psychologist;

    public function __construct(
        string $name, 
        string $surnames, 
        string $dni, 
        DateTime $birthDate,
        string $phoneNumber,
        string $email,
        string $photo,
    ) {
        parent::__construct($name, $surnames, $dni, $birthDate, $phoneNumber, $email, $photo, [User::ROLE_USER]);
    }

    public function getDiagnostic(): string
    {
        return (string) $this->diagnostic;
    }
    
    public function setDiagnostic(string $diagnostic): self
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getCaseHistory(): string
    {
        return (string) $this->caseHistory;
    }
    
    public function setCaseHistory(string $caseHistory): self
    {
        $this->caseHistory = $caseHistory;

        return $this;
    }

    public function getPsychologist(): Psychologist
    {
        return $this->psychologist;
    }
    
    public function setPsychologist(Psychologist $psychologist): self
    {
        $this->psychologist = $psychologist;

        return $this;
    }

    public function __toString()
    {
        return $this->name." ".$this->surnames;
    }
}
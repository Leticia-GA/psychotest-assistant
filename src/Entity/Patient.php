<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Patient extends User
{
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diagnostic;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $caseHistory;

    public function __construct(
        string $name, 
        string $surnames, 
        string $email,
        string $phoneNumber
    ) {
        parent::__construct($name, $surnames, $email, [User::ROLE_USER]);
        $this->phoneNumber = $phoneNumber;
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
}
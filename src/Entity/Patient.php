<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Patient extends User
{
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

    public function __construct(string $name, string $surnames, string $phoneNumber)
    {
        $this->name = $name;
        $this->surnames = $surnames;
        $this->phoneNumber = $phoneNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Patient
    {
        $this->name = $name;

        return $this;
    }

    public function getSurnames(): string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): Patient
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(string $phoneNumber): Patient
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
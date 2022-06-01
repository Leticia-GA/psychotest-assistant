<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Clinic 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=200)
     */
    private $info;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $openingHours;

    public function __construct(int $id, string $info, string $phoneNumber, string $email, string $location, string $openingHours)
    {
        $this->id = 1;
        $this->info = $info;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->location = $location;
        $this->openingHours = $openingHours;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getLocation()
    {
        return $this->location;
    }

    public function getOpeningHours()
    {
        return $this->openingHours;
    }
}
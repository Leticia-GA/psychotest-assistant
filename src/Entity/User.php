<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "patient" = "Patient", "psychologist" = "Psychologist"})
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Ya existe un usuario con el mismo email"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = "ROLE_USER";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_PSYC = "ROLE_PSYC";
    private const PROFILE_PHOTO = "https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="El nombre no puede contener números."
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Los apellidos no pueden contener números."
     * )
     */
    protected $surnames;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $dni;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *      message = "El email '{{ value }}' no es válido." 
     * )
     */
    protected $email;

     /**
     * @ORM\Column(type="string", length=100)
     */
    protected $photo;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    public function __construct(string $name, string $surnames, string $dni, DateTime $birthDate, string $phoneNumber, string $email, string $photo, array $roles)
    {
        $this->name = $name;
        $this->surnames = $surnames;
        $this->dni = $dni;
        $this->birthDate = $birthDate;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->photo = self::PROFILE_PHOTO;
        $this->roles = $roles;
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

    public function getSurnames(): string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
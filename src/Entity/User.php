<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="users")
     */
    private $groupe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $UserCreation;

    /**
     * @ORM\OneToOne(targetEntity=Responsable::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsable;

    /**
     * @ORM\OneToOne(targetEntity=District::class, cascade={"persist", "remove"})
     */
    private $district;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bActif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstConnection;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnection;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getUserCreation(): ?string
    {
        return $this->UserCreation;
    }

    public function setUserCreation(string $UserCreation): self
    {
        $this->UserCreation = $UserCreation;

        return $this;
    }

    public function getResponsable(): ?responsable
    {
        return $this->responsable;
    }

    public function setResponsable(responsable $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getBActif(): ?bool
    {
        return $this->bActif;
    }

    public function setBActif(bool $bActif): self
    {
        $this->bActif = $bActif;

        return $this;
    }

    public function getFirstConnection(): ?bool
    {
        return $this->firstConnection;
    }

    public function setFirstConnection(bool $firstConnection): self
    {
        $this->firstConnection = $firstConnection;

        return $this;
    }

    public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function setLastConnection(?\DateTimeInterface $lastConnection): self
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }

    
}

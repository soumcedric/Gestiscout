<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
abstract class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")

     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)

     */
    private $Password;


    private $ConfirmPassword;

    /**
     * @ORM\Column(type="datetime", nullable=true)

     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\OneToOne(targetEntity=Responsable::class, cascade={"persist", "remove"})
     */
    private $Responsable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    public function getId(): ?int
    {
        return $this->id;
    }




    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }



    public function getConfirmPassword(): ?string
    {
        return $this->ConfirmPassword;
    }

    public function setConfirmPassword(string $ConfirmPass): self
    {
        $this->ConfirmPassword = $ConfirmPass;

        return $this;
    }
















    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->DateModification;
    }

    public function setDateModification(?\DateTimeInterface $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->Responsable;
    }

    public function setResponsable(?Responsable $Responsable): self
    {
        $this->Responsable = $Responsable;

        return $this;
    }



    public  function  eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public  function getRoles(): array
    {
        // TODO: Implement getRoles() method.
        return ['ROLE_USER'];
    }

    public  function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public  function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}

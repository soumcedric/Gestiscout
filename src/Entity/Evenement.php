<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="integer")
     */
    private $Entite;

    /**
     * @ORM\Column(type="integer")
     */
    private $IdEntite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

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

    public function getUserCreation(): ?int
    {
        return $this->UserCreation;
    }

    public function setUserCreation(int $UserCreation): self
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

    public function getUserModification(): ?int
    {
        return $this->UserModification;
    }

    public function setUserModification(?int $UserModification): self
    {
        $this->UserModification = $UserModification;

        return $this;
    }

    public function getEntite(): ?int
    {
        return $this->Entite;
    }

    public function setEntite(int $Entite): self
    {
        $this->Entite = $Entite;

        return $this;
    }

    public function getIdEntite(): ?int
    {
        return $this->IdEntite;
    }

    public function setIdEntite(int $IdEntite): self
    {
        $this->IdEntite = $IdEntite;

        return $this;
    }
}

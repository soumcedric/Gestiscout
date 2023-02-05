<?php

namespace App\Entity;

use App\Repository\SousRubriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousRubriqueRepository::class)
 */
class SousRubrique
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
    private $Code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\ManyToOne(targetEntity=Rubrique::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Rubrique;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
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

    public function getType(): ?int
    {
        return $this->Type;
    }

    public function setType(?int $Type): self
    {
        $this->Type = $Type;

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

    public function setUserCreation(?int $UserCreation): self
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

    public function getRubrique(): ?Rubrique
    {
        return $this->Rubrique;
    }

    public function setRubrique(?Rubrique $Rubrique): self
    {
        $this->Rubrique = $Rubrique;

        return $this;
    }
}

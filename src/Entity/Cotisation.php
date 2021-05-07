<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CotisationRepository::class)
 */
class Cotisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("read")
     */
    private $Matricule;

    /**
     * @ORM\ManyToOne(targetEntity=JEune::class)
     */
    private $Jeune;

    /**
     * @ORM\ManyToOne(targetEntity=Responsable::class)
     */
    private $Responsable;

    /**
     * @ORM\ManyToOne(targetEntity=AnneePastorale::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $AnneePastorale;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserModification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getJeune(): ?JEune
    {
        return $this->Jeune;
    }

    public function setJeune(?JEune $Jeune): self
    {
        $this->Jeune = $Jeune;

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

    public function getAnneePastorale(): ?AnneePastorale
    {
        return $this->AnneePastorale;
    }

    public function setAnneePastorale(?AnneePastorale $AnneePastorale): self
    {
        $this->AnneePastorale = $AnneePastorale;

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

    public function setUserCreation(?string $UserCreation): self
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

    public function getUserModification(): ?string
    {
        return $this->UserModification;
    }

    public function setUserModification(?string $UserModification): self
    {
        $this->UserModification = $UserModification;

        return $this;
    }
}

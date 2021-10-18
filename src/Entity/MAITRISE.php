<?php

namespace App\Entity;

use App\Repository\MAITRISERepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MAITRISERepository::class)
 */
class MAITRISE
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ACTIVITES::class, inversedBy="Responsable")
     */
    private $Activite;

    /**
     * @ORM\ManyToOne(targetEntity=Responsable::class, inversedBy="Maitrises")
     */
    private $relation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Bactif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivite(): ?ACTIVITES
    {
        return $this->Activite;
    }

    public function setActivite(?ACTIVITES $Activite): self
    {
        $this->Activite = $Activite;

        return $this;
    }

    public function getRelation(): ?RESPONSABLE
    {
        return $this->relation;
    }

    public function setRelation(?RESPONSABLE $relation): self
    {
        $this->relation = $relation;

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

    public function setDateModification(\DateTimeInterface $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getUserModification(): ?\DateTimeInterface
    {
        return $this->UserModification;
    }

    public function setUserModification(?\DateTimeInterface $UserModification): self
    {
        $this->UserModification = $UserModification;

        return $this;
    }

    public function getBactif(): ?bool
    {
        return $this->Bactif;
    }

    public function setBactif(bool $Bactif): self
    {
        $this->Bactif = $Bactif;

        return $this;
    }
}

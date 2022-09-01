<?php

namespace App\Entity;

use App\Repository\SessionFormationResponsableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionFormationResponsableRepository::class)
 */
class SessionFormationResponsable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $RefDiplome;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $BconfirmPariticpation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Binscrit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\ManyToOne(targetEntity=sessionformation::class, inversedBy="sessionFormationResponsables")
     */
    private $sessionId;

    /**
     * @ORM\ManyToOne(targetEntity=Responsable::class, inversedBy="sessionFormationResponsables")
     */
    private $responsableId;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getRefDiplome(): ?string
    {
        return $this->RefDiplome;
    }

    public function setRefDiplome(?string $RefDiplome): self
    {
        $this->RefDiplome = $RefDiplome;

        return $this;
    }

    public function getBconfirmPariticpation(): ?bool
    {
        return $this->BconfirmPariticpation;
    }

    public function setBconfirmPariticpation(bool $BconfirmPariticpation): self
    {
        $this->BconfirmPariticpation = $BconfirmPariticpation;

        return $this;
    }

    public function getBinscrit(): ?bool
    {
        return $this->Binscrit;
    }

    public function setBinscrit(bool $Binscrit): self
    {
        $this->Binscrit = $Binscrit;

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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->DateModification;
    }

    public function setDateModification(?\DateTimeInterface $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getSessionId(): ?sessionformation
    {
        return $this->sessionId;
    }

    public function setSessionId(?sessionformation $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getResponsableId(): ?Responsable
    {
        return $this->responsableId;
    }

    public function setResponsableId(?Responsable $responsableId): self
    {
        $this->responsableId = $responsableId;

        return $this;
    }
}

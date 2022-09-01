<?php

namespace App\Entity;

use App\Repository\DETAILSRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DETAILSRepository::class)
 */
class DETAILS
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
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $Deroulement;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="time")
     */
    private $Heuredebut;

    /**
     * @ORM\Column(type="time")
     */
    private $HeureFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Cible;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $Objectif;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $Impact;

    /**
     * @ORM\Column(type="integer")
     */
    private $Statut;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $Commentaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Bactif;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ResponsableActivite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Fonction;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $Contact;

    /**
     * @ORM\ManyToOne(targetEntity=Branche::class, inversedBy="Details")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Branche;

    /**
     * @ORM\ManyToOne(targetEntity=ACTIVITES::class, inversedBy="Details")
     */
    private $Activite;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateValidation;

  
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDeroulement(): ?string
    {
        return $this->Deroulement;
    }

    public function setDeroulement(string $Deroulement): self
    {
        $this->Deroulement = $Deroulement;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHeuredebut(): ?\DateTimeInterface
    {
        return $this->Heuredebut;
    }

    public function setHeuredebut(\DateTimeInterface $Heuredebut): self
    {
        $this->Heuredebut = $Heuredebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->HeureFin;
    }

    public function setHeureFin(\DateTimeInterface $HeureFin): self
    {
        $this->HeureFin = $HeureFin;

        return $this;
    }

    public function getCible(): ?string
    {
        return $this->Cible;
    }

    public function setCible(string $Cible): self
    {
        $this->Cible = $Cible;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->Objectif;
    }

    public function setObjectif(?string $Objectif): self
    {
        $this->Objectif = $Objectif;

        return $this;
    }

    public function getImpact(): ?string
    {
        return $this->Impact;
    }

    public function setImpact(?string $Impact): self
    {
        $this->Impact = $Impact;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->Statut;
    }

    public function setStatut(int $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

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

    public function getUserCreation(): ?int
    {
        return $this->UserCreation;
    }

    public function setUserCreation(?int $UserCreation): self
    {
        $this->UserCreation = $UserCreation;

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

    public function getUserModification(): ?int
    {
        return $this->UserModification;
    }

    public function setUserModification(?int $UserModification): self
    {
        $this->UserModification = $UserModification;

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

    public function getResponsableActivite(): ?string
    {
        return $this->ResponsableActivite;
    }

    public function setResponsableActivite(?string $ResponsableActivite): self
    {
        $this->ResponsableActivite = $ResponsableActivite;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(?string $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(?string $Contact): self
    {
        $this->Contact = $Contact;

        return $this;
    }

    public function getBranche(): ?Branche
    {
        return $this->Branche;
    }

    public function setBranche(?Branche $Branche): self
    {
        $this->Branche = $Branche;

        return $this;
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

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->DateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $DateValidation): self
    {
        $this->DateValidation = $DateValidation;

        return $this;
    }

}

<?php

namespace App\Entity;

use App\Repository\JEUNERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=JEUNERepository::class)
 */
class JEUNE
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",nullable=false)
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     */
    private $Prenoms;



    /**
     * @Groups("read")
     */
    private $DateNaiss;


    /**
     * @ORM\Column(type="date")
     * @Groups("read")
     */
    private $Dob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $LieuHabitation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $Occupation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $NomPere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $NumPere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $NomMere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $NumMere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $Matricule;

    /**
     * @ORM\OneToMany(targetEntity=INSCRIPTION::class, mappedBy="Jeunes", cascade={"persist", "remove"})
     * @Groups("read")
     */
    private $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Branche::class, inversedBy="jeunes")
     * @Groups("read")
     */
    private $branche;




    /**
     * @Groups("read")
     */
    private $brancheId;




    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="Jeunes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Groupe;

    /**
     * @ORM\Column(type="integer")
     */
    private $Statut;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups("read")
     */
    private $Telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="Jeunes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Genre;



    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->Prenoms;
    }

    public function setPrenoms(string $Prenoms): self
    {
        $this->Prenoms = $Prenoms;

        return $this;
    }






    public function getBrancheId(): ?int
    {
        return $this->brancheId;
    }

    public function setBrancheId(int $brancheid): self
    {
        $this->brancheId = $brancheid;

        return $this;
    }
























    public function getDateNaiss(): ?string
    {
        return $this->DateNaiss;
    }

    public function setDateNaiss(string $datenaiss): self
    {
        $this->DateNaiss = $datenaiss;

        return $this;
    }



















    public function getDob(): ?\DateTimeInterface
    {
        return $this->Dob;
    }

    public function setDob(\DateTimeInterface $Dob): self
    {
        $this->Dob = $Dob;

        return $this;
    }

    public function getLieuHabitation(): ?string
    {
        return $this->LieuHabitation;
    }

    public function setLieuHabitation(?string $LieuHabitation): self
    {
        $this->LieuHabitation = $LieuHabitation;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->Occupation;
    }

    public function setOccupation(?string $Occupation): self
    {
        $this->Occupation = $Occupation;

        return $this;
    }

    public function getNomPere(): ?string
    {
        return $this->NomPere;
    }

    public function setNomPere(?string $NomPere): self
    {
        $this->NomPere = $NomPere;

        return $this;
    }

    public function getNumPere(): ?string
    {
        return $this->NumPere;
    }

    public function setNumPere(?string $NumPere): self
    {
        $this->NumPere = $NumPere;

        return $this;
    }

    public function getNomMere(): ?string
    {
        return $this->NomMere;
    }

    public function setNomMere(?string $NomMere): self
    {
        $this->NomMere = $NomMere;

        return $this;
    }

    public function getNumMere(): ?string
    {
        return $this->NumMere;
    }

    public function setNumMere(?string $NumMere): self
    {
        $this->NumMere = $NumMere;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(?string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setJeunes($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getJeunes() === $this) {
                $inscription->setJeunes(null);
            }
        }

        return $this;
    }

    public function getBranche(): ?branche
    {
        return $this->branche;
    }

    public function setBranche(?branche $branche): self
    {
        $this->branche = $branche;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->Groupe;
    }

    public function setGroupe(?Groupe $Groupe): self
    {
        $this->Groupe = $Groupe;

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

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(?string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->Genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->Genre = $genre;

        return $this;
    }

}

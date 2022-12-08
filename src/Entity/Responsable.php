<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ResponsableRepository::class)
 */
class Responsable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",nullable=false)
     * @Groups({"show_chef"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_chef"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_chef"})
     */
    private $Prenoms;

    /**
     * @ORM\Column(type="date")
     * @Groups({"show_chef"})
     */
    private $Dob;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_chef"})
     */
    private $Habitation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_chef"})
     */
    private $Occupation;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"show_chef"})
     */
    private $Telephone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_chef"})
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_chef"})
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\OneToMany(targetEntity=ExercerFonction::class, mappedBy="Responsable", cascade={"persist", "remove"})
     */
    private $exercerFonctions;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class)
     */
    private $groupe;

    /**
     * @ORM\Column(type="integer")
     */
    private $Statut;

    /**
     * @Groups({"show_chef"})
     */
    private $fonctionId;
     /**
      * @Groups({"show_chef"})
      */
    private $fonctionLibelle;


    /**
     * @Groups({"show_chef"})
     */
    private $dateNaiss;
    /**
     * @Groups({"show_chef"})
     */
    private $Matricule;



    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="responsable", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="responsables")
     */
    private $Genre;

    /**
     * @ORM\OneToMany(targetEntity=MAITRISE::class, mappedBy="relation")
     */
    private $Maitrises;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="responsable",cascade={"persist","remove"})
     * @Groups({"show_chef"})
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=ResponsableFormation::class, mappedBy="responsable_id",cascade={"persist","remove"})
     */
    private $responsableFormations;

    /**
     * @ORM\OneToMany(targetEntity=SessionFormationResponsable::class, mappedBy="responsableId")
     */
    private $sessionFormationResponsables;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"show_chef"})
     */
    private $email;



//    /**
//     * @ORM\OneToOne(targetEntity=Genre::class,cascade={"persist", "remove"})
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $Genre;












    public function __construct()
    {
        $this->exercerFonctions = new ArrayCollection();
        $this->Maitrises = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->responsableFormations = new ArrayCollection();
        $this->sessionFormationResponsables = new ArrayCollection();
    }


    public function getFonctionId(){
        return $this->fonctionId;
    }
    public function getFonctionLibelle(){
        return $this->fonctionLibelle;
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


    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }
    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

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

    public function getHabitation(): ?string
    {
        return $this->Habitation;
    }

    public function setHabitation(string $Habitation): self
    {
        $this->Habitation = $Habitation;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->Occupation;
    }

    public function setOccupation(string $Occupation): self
    {
        $this->Occupation = $Occupation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }


    public function setDateNaiss(string $DateNaiss): self
    {
        $this->dateNaiss = $DateNaiss;

        return $this;
    }

    public function getDateNaiss(): ?string
    {
        return $this->dateNaiss;
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

    public function getDateModification(): ?string
    {
        return $this->DateModification;
    }

    public function setDateModification(?string $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getUserModification(): ?string
    {
        return $this->UserModification;
    }

    public function setUserModification(string $UserModification): self
    {
        $this->UserModification = $UserModification;

        return $this;
    }

    /**
     * @return Collection|ExercerFonction[]
     */
    public function getExercerFonctions(): Collection
    {
        return $this->exercerFonctions;
    }

    public function addExercerFonction(ExercerFonction $exercerFonction): self
    {
        if (!$this->exercerFonctions->contains($exercerFonction)) {
            $this->exercerFonctions[] = $exercerFonction;
            $exercerFonction->setResponsable($this);
        }

        return $this;
    }

    public function removeExercerFonction(ExercerFonction $exercerFonction): self
    {
        if ($this->exercerFonctions->removeElement($exercerFonction)) {
            // set the owning side to null (unless already changed)
            if ($exercerFonction->getResponsable() === $this) {
                $exercerFonction->setResponsable(null);
            }
        }

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

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


    public function setFonctionId(int $fonctionId)
    {
        $this->fonctionId = $fonctionId;

        return $this;
    }

    
    public function setFonctionLibelle(string $fonctionLibelle)
    {
        $this->fonctionLibelle = $fonctionLibelle;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getResponsable() !== $this) {
            $user->setResponsable($this);
        }

        $this->user = $user;

        return $this;
    }

//    public function getGenre(): ?Genre
//    {
//        return $this->Genre;
//    }
//
//    public function setGenre(Genre $Genre): self
//    {
//        $this->Genre = $Genre;
//
//        return $this;
//    }

public function getGenre(): ?Genre
{
    return $this->Genre;
}

public function setGenre(?Genre $Genre): self
{
    $this->Genre = $Genre;

    return $this;
}

/**
 * @return Collection|MAITRISE[]
 */
public function getMaitrises(): Collection
{
    return $this->Maitrises;
}

public function addMaitrise(MAITRISE $maitrise): self
{
    if (!$this->Maitrises->contains($maitrise)) {
        $this->Maitrises[] = $maitrise;
        $maitrise->setRelation($this);
    }

    return $this;
}

public function removeMaitrise(MAITRISE $maitrise): self
{
    if ($this->Maitrises->removeElement($maitrise)) {
        // set the owning side to null (unless already changed)
        if ($maitrise->getRelation() === $this) {
            $maitrise->setRelation(null);
        }
    }

    return $this;
}

/**
 * @return Collection|Formation[]
 */
public function getFormations(): Collection
{
    return $this->formations;
}

public function addFormation(Formation $formation): self
{
    if (!$this->formations->contains($formation)) {
        $this->formations[] = $formation;
        $formation->addResponsable($this);
    }

    return $this;
}

public function removeFormation(Formation $formation): self
{
    if ($this->formations->removeElement($formation)) {
        $formation->removeResponsable($this);
    }

    return $this;
}

/**
 * @return Collection|ResponsableFormation[]
 */
public function getResponsableFormations(): Collection
{
    return $this->responsableFormations;
}

public function addResponsableFormation(ResponsableFormation $responsableFormation): self
{
    if (!$this->responsableFormations->contains($responsableFormation)) {
        $this->responsableFormations[] = $responsableFormation;
        $responsableFormation->setResponsableId($this);
    }

    return $this;
}

public function removeResponsableFormation(ResponsableFormation $responsableFormation): self
{
    if ($this->responsableFormations->removeElement($responsableFormation)) {
        // set the owning side to null (unless already changed)
        if ($responsableFormation->getResponsableId() === $this) {
            $responsableFormation->setResponsableId(null);
        }
    }

    return $this;
}

/**
 * @return Collection|SessionFormationResponsable[]
 */
public function getSessionFormationResponsables(): Collection
{
    return $this->sessionFormationResponsables;
}

public function addSessionFormationResponsable(SessionFormationResponsable $sessionFormationResponsable): self
{
    if (!$this->sessionFormationResponsables->contains($sessionFormationResponsable)) {
        $this->sessionFormationResponsables[] = $sessionFormationResponsable;
        $sessionFormationResponsable->setResponsableId($this);
    }

    return $this;
}

public function removeSessionFormationResponsable(SessionFormationResponsable $sessionFormationResponsable): self
{
    if ($this->sessionFormationResponsables->removeElement($sessionFormationResponsable)) {
        // set the owning side to null (unless already changed)
        if ($sessionFormationResponsable->getResponsableId() === $this) {
            $sessionFormationResponsable->setResponsableId(null);
        }
    }

    return $this;
}

public function getEmail(): ?string
{
    return $this->email;
}

public function setEmail(?string $email): self
{
    $this->email = $email;

    return $this;
}




}

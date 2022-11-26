<?php

namespace App\Entity;

use App\Repository\DistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DistrictRepository::class)
 */
class District
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"district"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"district"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"district"})
     */
    private $Prenoms;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"district"})
     */
    private $Dob;

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

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"district"})
     */
    private $Telephone;

    /**
     * @ORM\ManyToMany(targetEntity=ExercerFonction::class, mappedBy="District")
     */
    private $exercerFonctions;

    // /**
    //  * @ORM\OneToOne(targetEntity=CaisseDistrict::class, mappedBy="district", cascade={"persist", "remove"})
    //  */
    // private $caisseDistrict;


    public function __construct()
    {
        $this->exercerFonctions = new ArrayCollection();
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

    public function getDob(): ?string
    {
        return $this->Dob;
    }

    public function setDob(string $Dob): self
    {
        $this->Dob = $Dob;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $exercerFonction->addDistrict($this);
        }

        return $this;
    }

    public function removeExercerFonction(ExercerFonction $exercerFonction): self
    {
        if ($this->exercerFonctions->removeElement($exercerFonction)) {
            $exercerFonction->removeDistrict($this);
        }

        return $this;
    }

    public function getCaisseDistrict(): ?CaisseDistrict
    {
        return $this->caisseDistrict;
    }

    public function setCaisseDistrict(?CaisseDistrict $caisseDistrict): self
    {
        // unset the owning side of the relation if necessary
        if ($caisseDistrict === null && $this->caisseDistrict !== null) {
            $this->caisseDistrict->setDistrict(null);
        }

        // set the owning side of the relation if necessary
        if ($caisseDistrict !== null && $caisseDistrict->getDistrict() !== $this) {
            $caisseDistrict->setDistrict($this);
        }

        $this->caisseDistrict = $caisseDistrict;

        return $this;
    }

}

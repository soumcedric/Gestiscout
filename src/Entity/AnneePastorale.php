<?php

namespace App\Entity;

use App\Repository\AnneePastoraleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AnneePastoraleRepository::class)
 */
class AnneePastorale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("readAnnee")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups("readAnnee")
     */
    private $CodeAnnee;

    /**
     * @ORM\Column(type="date")
     * @Groups("readAnnee")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups("readAnnee")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("readAnnee")
     */
    private $bActif;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("readAnnee")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("readAnnee")
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("readAnnee")
     */
    private $DateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("readAnnee")
     */
    private $UserModification;

    /**
     * @ORM\OneToMany(targetEntity=INSCRIPTION::class, mappedBy="Annee")
    */
    private $INSCRIPTIONS;

    /**
     * @ORM\OneToMany(targetEntity=ExercerFonction::class, mappedBy="AnneePastorale")
     */
    private $exercerFonctions;



    public function __construct()
    {
        $this->INSCRIPTIONS = new ArrayCollection();
        $this->Responsable = new ArrayCollection();
        $this->exercerFonctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAnnee(): ?string
    {
        return $this->CodeAnnee;
    }

    public function setCodeAnnee(string $CodeAnnee): self
    {
        $this->CodeAnnee = $CodeAnnee;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getBActif(): ?bool
    {
        return $this->bActif;
    }

    public function setBActif(bool $bActif): self
    {
        $this->bActif = $bActif;

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

    /**
     * @return Collection|INSCRIPTION[]
     */
    public function getINSCRIPTIONS(): Collection
    {
        return $this->INSCRIPTIONS;
    }

    public function addINSCRIPTION(INSCRIPTION $iNSCRIPTION): self
    {
        if (!$this->INSCRIPTIONS->contains($iNSCRIPTION)) {
            $this->INSCRIPTIONS[] = $iNSCRIPTION;
            $iNSCRIPTION->setAnnee($this);
        }

        return $this;
    }

    public function removeINSCRIPTION(INSCRIPTION $iNSCRIPTION): self
    {
        if ($this->INSCRIPTIONS->removeElement($iNSCRIPTION)) {
            // set the owning side to null (unless already changed)
            if ($iNSCRIPTION->getAnnee() === $this) {
                $iNSCRIPTION->setAnnee(null);
            }
        }

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
            $exercerFonction->setAnneePastorale($this);
        }

        return $this;
    }

    public function removeExercerFonction(ExercerFonction $exercerFonction): self
    {
        if ($this->exercerFonctions->removeElement($exercerFonction)) {
            // set the owning side to null (unless already changed)
            if ($exercerFonction->getAnneePastorale() === $this) {
                $exercerFonction->setAnneePastorale(null);
            }
        }

        return $this;
    }

}

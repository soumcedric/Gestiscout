<?php

namespace App\Entity;

use App\Repository\ExercerFonctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExercerFonctionRepository::class)
 */
class ExercerFonction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateFin;

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
     * @ORM\ManyToOne(targetEntity=AnneePastorale::class, inversedBy="exercerFonctions")
     */
    private $AnneePastorale;

    /**
     * @ORM\ManyToOne(targetEntity=Responsable::class, inversedBy="exercerFonctions")
     */
    private $Responsable;

    /**
     * @ORM\ManyToOne(targetEntity=FONCTION::class, inversedBy="exercerFonctions")
     */
    private $Fonction;

    /**
     * @ORM\ManyToMany(targetEntity=District::class, inversedBy="exercerFonctions")
     */
    private $District;

    public function __construct()
    {
        $this->District = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

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

    public function setUserModification(string $UserModification): self
    {
        $this->UserModification = $UserModification;

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

    public function getResponsable(): ?Responsable
    {
        return $this->Responsable;
    }

    public function setResponsable(?Responsable $Responsable): self
    {
        $this->Responsable = $Responsable;

        return $this;
    }

    public function getFonction(): ?Fonction
    {
        return $this->Fonction;
    }

    public function setFonction(?Fonction $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    /**
     * @return Collection|District[]
     */
    public function getDistrict(): Collection
    {
        return $this->District;
    }

    public function addDistrict(District $district): self
    {
        if (!$this->District->contains($district)) {
            $this->District[] = $district;
        }

        return $this;
    }

    public function removeDistrict(District $district): self
    {
        $this->District->removeElement($district);

        return $this;
    }


}

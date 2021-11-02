<?php

namespace App\Entity;

use App\Repository\BrancheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BrancheRepository::class)
 */
class Branche
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("branche")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("branche")
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("branche")
     */
    private $TrancheAge;

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
     * @ORM\OneToMany(targetEntity=JEUNE::class, mappedBy="branche")
     */
    private $jeunes;

    /**
     * @ORM\OneToMany(targetEntity=DETAILS::class, mappedBy="Branche")
     */
    private $Details;

    /**
     * @ORM\OneToMany(targetEntity=ACTIVITES::class, mappedBy="Branche")
     */
    private $Activities;

    public function __construct()
    {
        $this->jeunes = new ArrayCollection();
        $this->Details = new ArrayCollection();
        $this->Activities = new ArrayCollection();
    }

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

    public function getTrancheAge(): ?string
    {
        return $this->TrancheAge;
    }

    public function setTrancheAge(string $TrancheAge): self
    {
        $this->TrancheAge = $TrancheAge;

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
     * @return Collection|Jeune[]
     */
    public function getJeunes(): Collection
    {
        return $this->jeunes;
    }

    public function addJeune(Jeune $jeune): self
    {
        if (!$this->jeunes->contains($jeune)) {
            $this->jeunes[] = $jeune;
            $jeune->setBranche($this);
        }

        return $this;
    }

    public function removeJeune(Jeune $jeune): self
    {
        if ($this->jeunes->removeElement($jeune)) {
            // set the owning side to null (unless already changed)
            if ($jeune->getBranche() === $this) {
                $jeune->setBranche(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DETAILS[]
     */
    public function getDetails(): Collection
    {
        return $this->Details;
    }

    public function addDetail(DETAILS $detail): self
    {
        if (!$this->Details->contains($detail)) {
            $this->Details[] = $detail;
            $detail->setBranche($this);
        }

        return $this;
    }

    public function removeDetail(DETAILS $detail): self
    {
        if ($this->Details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getBranche() === $this) {
                $detail->setBranche(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ACTIVITES[]
     */
    public function getActivities(): Collection
    {
        return $this->Activities;
    }

    public function addActivity(ACTIVITES $activity): self
    {
        if (!$this->Activities->contains($activity)) {
            $this->Activities[] = $activity;
            $activity->setBranche($this);
        }

        return $this;
    }

    public function removeActivity(ACTIVITES $activity): self
    {
        if ($this->Activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getBranche() === $this) {
                $activity->setBranche(null);
            }
        }

        return $this;
    }
}

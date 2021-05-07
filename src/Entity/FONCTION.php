<?php

namespace App\Entity;

use App\Repository\FONCTIONRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FONCTIONRepository::class)
 */
class FONCTION
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("fonction")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("fonction")
     */
    private $Code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("fonction")
     */
    private $Libelle;

    /**
     * @ORM\Column(type="datetime", nullable=true)

     */
    private $DateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)

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
     * @ORM\OneToMany(targetEntity=ExercerFonction::class, mappedBy="Fonction")
     */
    private $exercerFonctions;

    public function __construct()
    {
        $this->exercerFonctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getUserCreation(): ?\DateTimeInterface
    {
        return $this->UserCreation;
    }

    public function setUserCreation(?\DateTimeInterface $UserCreation): self
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
            $exercerFonction->setFonction($this);
        }

        return $this;
    }

    public function removeExercerFonction(ExercerFonction $exercerFonction): self
    {
        if ($this->exercerFonctions->removeElement($exercerFonction)) {
            // set the owning side to null (unless already changed)
            if ($exercerFonction->getFonction() === $this) {
                $exercerFonction->setFonction(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\MouvementTresoActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MouvementTresoActiviteRepository::class)
 */
class MouvementTresoActivite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $Montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateMouvement;

    /**
     * @ORM\Column(type="integer")
     */
    private $EventId;

    /**
     * @ORM\ManyToOne(targetEntity=SousRubrique::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $SousRubrique;

    /**
     * @ORM\ManyToOne(targetEntity=Periode::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Periode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Commentaire;

    /**
     * @ORM\Column(type="smallint")
     */
    private $UserCreation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getDateMouvement(): ?\DateTimeInterface
    {
        return $this->DateMouvement;
    }

    public function setDateMouvement(\DateTimeInterface $DateMouvement): self
    {
        $this->DateMouvement = $DateMouvement;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->EventId;
    }

    public function setEventId(int $EventId): self
    {
        $this->EventId = $EventId;

        return $this;
    }

    public function getSousRubrique(): ?SousRubrique
    {
        return $this->SousRubrique;
    }

    public function setSousRubrique(?SousRubrique $SousRubrique): self
    {
        $this->SousRubrique = $SousRubrique;

        return $this;
    }

    public function getPeriode(): ?Periode
    {
        return $this->Periode;
    }

    public function setPeriode(?Periode $Periode): self
    {
        $this->Periode = $Periode;

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

    public function getUserCreation(): ?int
    {
        return $this->UserCreation;
    }

    public function setUserCreation(int $UserCreation): self
    {
        $this->UserCreation = $UserCreation;

        return $this;
    }
}

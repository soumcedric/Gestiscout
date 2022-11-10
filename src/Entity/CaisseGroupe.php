<?php

namespace App\Entity;

use App\Repository\CaisseGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaisseGroupeRepository::class)
 */
class CaisseGroupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usercreate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $solde;
    

    /**
     * @ORM\OneToOne(targetEntity=groupe::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    public function setDatecreate(\DateTimeInterface $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getUsercreate(): ?int
    {
        return $this->usercreate;
    }

    public function setUsercreate(?int $usercreate): self
    {
        $this->usercreate = $usercreate;

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

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(?string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }
}

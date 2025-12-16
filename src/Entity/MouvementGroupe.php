<?php

namespace App\Entity;

use App\Repository\MouvementGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MouvementGroupeRepository::class)
 */
class MouvementGroupe
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
    private $datemouvement;

    /**
     * @ORM\Column(type="bigint")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=groupe::class)
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Periode::class)
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity=caissegroupe::class)
     */
    private $caisse;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMouvement::class)
     */
    private $typemouvement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="integer")
     */
    private $usercreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usermodification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatemouvement(): ?\DateTimeInterface
    {
        return $this->datemouvement;
    }

    public function setDatemouvement(\DateTimeInterface $datemouvement): self
    {
        $this->datemouvement = $datemouvement;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getPeriode(): ?Periode
    {
        return $this->periode;
    }

    public function setPeriode(?Periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getCaisse(): ?caissegroupe
    {
        return $this->caisse;
    }

    public function setCaisse(?caissegroupe $caisse): self
    {
        $this->caisse = $caisse;

        return $this;
    }

    public function getTypemouvement(): ?typemouvement
    {
        return $this->typemouvement;
    }

    public function setTypemouvement(?typemouvement $typemouvement): self
    {
        $this->typemouvement = $typemouvement;

        return $this;
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

    public function getUsercreate(): ?int
    {
        return $this->usercreate;
    }

    public function setUsercreate(int $usercreate): self
    {
        $this->usercreate = $usercreate;

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

    public function getUsermodification(): ?int
    {
        return $this->usermodification;
    }

    public function setUsermodification(?int $usermodification): self
    {
        $this->usermodification = $usermodification;

        return $this;
    }
}

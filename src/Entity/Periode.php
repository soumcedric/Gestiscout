<?php

namespace App\Entity;

use App\Repository\PeriodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeriodeRepository::class)
 */
class Periode
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
    private $datedebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datefin;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @ORM\Column(type="integer")
     */
    private $usercreate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usermodification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

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

    public function setUsercreate(int $usercreate): self
    {
        $this->usercreate = $usercreate;

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

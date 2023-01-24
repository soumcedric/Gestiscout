<?php

namespace App\Entity;

use App\Repository\CaisseDistrictRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaisseDistrictRepository::class)
 */
class CaisseDistrict
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
    private $usermodification;

    /**
     * @ORM\Column(type="integer")
     */
    private $usercreate;

  

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateSolde;

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

    public function getUsermodification(): ?int
    {
        return $this->usermodification;
    }

    public function setUsermodification(?int $usermodification): self
    {
        $this->usermodification = $usermodification;

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



 
    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateSolde(): ?\DateTimeInterface
    {
        return $this->dateSolde;
    }

    public function setDateSolde(\DateTimeInterface $dateSolde): self
    {
        $this->dateSolde = $dateSolde;

        return $this;
    }
}

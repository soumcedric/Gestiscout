<?php

namespace App\Entity;

use App\Repository\MouvementEntiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MouvementEntiteRepository::class)
 */
class MouvementEntite
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
    private $datemvt;

    /**
     * @ORM\Column(type="bigint")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $entiteId;

    /**
     * @ORM\Column(type="integer")
     */
    private $usermvt;

    /**
     * @ORM\ManyToOne(targetEntity=periode::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity=sousrubrique::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sousrubrique;

    /**
     * @ORM\Column(type="smallint")
     */
    private $entite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatemvt(): ?\DateTimeInterface
    {
        return $this->datemvt;
    }

    public function setDatemvt(\DateTimeInterface $datemvt): self
    {
        $this->datemvt = $datemvt;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEntiteId(): ?int
    {
        return $this->entiteId;
    }

    public function setEntiteId(int $entiteId): self
    {
        $this->entiteId = $entiteId;

        return $this;
    }

    public function getUsermvt(): ?int
    {
        return $this->usermvt;
    }

    public function setUsermvt(int $usermvt): self
    {
        $this->usermvt = $usermvt;

        return $this;
    }

    public function getPeriode(): ?periode
    {
        return $this->periode;
    }

    public function setPeriode(?periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getSousrubrique(): ?sousrubrique
    {
        return $this->sousrubrique;
    }

    public function setSousrubrique(?sousrubrique $sousrubrique): self
    {
        $this->sousrubrique = $sousrubrique;

        return $this;
    }

    public function getEntite(): ?int
    {
        return $this->entite;
    }

    public function setEntite(int $entite): self
    {
        $this->entite = $entite;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\INSCRIPTIONRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=INSCRIPTIONRepository::class)
 */
class INSCRIPTION
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
    private $DateInscription;

    /**
     * @ORM\ManyToOne(targetEntity=JEUNE::class, inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Jeunes;

    /**
     * @ORM\ManyToOne(targetEntity=AnneePastorale::class, inversedBy="INSCRIPTIONS")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->DateInscription;
    }

    public function setDateInscription(\DateTimeInterface $DateInscription): self
    {
        $this->DateInscription = $DateInscription;

        return $this;
    }

    public function getJeunes(): ?Jeune
    {
        return $this->Jeunes;
    }

    public function setJeunes(?Jeune $Jeunes): self
    {
        $this->Jeunes = $Jeunes;

        return $this;
    }

    public function getAnnee(): ?AnneePastorale
    {
        return $this->Annee;
    }

    public function setAnnee(?AnneePastorale $Annee): self
    {
        $this->Annee = $Annee;

        return $this;
    }
}

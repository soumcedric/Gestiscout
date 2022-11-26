<?php

namespace App\Entity;

use App\Repository\TresorerieActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TresorerieActiviteRepository::class)
 */
class TresorerieActivite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $EventId;

    /**
     * @ORM\Column(type="bigint")
     */
    private $Solde;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateSolde;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $UserCreation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSolde(): ?string
    {
        return $this->Solde;
    }

    public function setSolde(string $Solde): self
    {
        $this->Solde = $Solde;

        return $this;
    }

    public function getDateSolde(): ?\DateTimeInterface
    {
        return $this->DateSolde;
    }

    public function setDateSolde(\DateTimeInterface $DateSolde): self
    {
        $this->DateSolde = $DateSolde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

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

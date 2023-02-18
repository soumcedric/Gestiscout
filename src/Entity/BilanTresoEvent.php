<?php

namespace App\Entity;

use App\Repository\BilanTresoEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BilanTresoEventRepository::class)
 */
class BilanTresoEvent
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
    private $TotalCredit;

    /**
     * @ORM\Column(type="bigint")
     */
    private $TotalDebit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateBilan;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UtilisateurCreation;

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



    public function getTotalCredit(): ?string
    {
        return $this->TotalCredit;
    }

    public function setTotalCredit(string $TotalCredit): self
    {
        $this->TotalCredit = $TotalCredit;

        return $this;
    }

    public function getTotalDebit(): ?string
    {
        return $this->TotalDebit;
    }

    public function setTotalDebit(string $TotalDebit): self
    {
        $this->TotalDebit = $TotalDebit;

        return $this;
    }

    public function getDateBilan(): ?\DateTimeInterface
    {
        return $this->DateBilan;
    }

    public function setDateBilan(\DateTimeInterface $DateBilan): self
    {
        $this->DateBilan = $DateBilan;

        return $this;
    }

    public function getUtilisateurCreation(): ?int
    {
        return $this->UtilisateurCreation;
    }

    public function setUtilisateurCreation(?int $UtilisateurCreation): self
    {
        $this->UtilisateurCreation = $UtilisateurCreation;

        return $this;
    }
}

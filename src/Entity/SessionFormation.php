<?php

namespace App\Entity;

use App\Repository\SessionFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionFormationRepository::class)
 */
class SessionFormation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("session")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups("session")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups("session")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("session")
     */
    private $DirecteurStage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("session")
     */
    private $Lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="sessionFormations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("session")
     */
    private $stageFormation;

    /**
     * @ORM\OneToMany(targetEntity=SessionFormationResponsable::class, mappedBy="sessionId")
     */
    private $sessionFormationResponsables;

    public function __construct()
    {
        $this->sessionFormationResponsables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getDirecteurStage(): ?string
    {
        return $this->DirecteurStage;
    }

    public function setDirecteurStage(?string $DirecteurStage): self
    {
        $this->DirecteurStage = $DirecteurStage;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(?string $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getStageFormation(): ?Formation
    {
        return $this->stageFormation;
    }

    public function setStageFormation(?Formation $stageFormation): self
    {
        $this->stageFormation = $stageFormation;

        return $this;
    }

    /**
     * @return Collection|SessionFormationResponsable[]
     */
    public function getSessionFormationResponsables(): Collection
    {
        return $this->sessionFormationResponsables;
    }

    public function addSessionFormationResponsable(SessionFormationResponsable $sessionFormationResponsable): self
    {
        if (!$this->sessionFormationResponsables->contains($sessionFormationResponsable)) {
            $this->sessionFormationResponsables[] = $sessionFormationResponsable;
            $sessionFormationResponsable->setSessionId($this);
        }

        return $this;
    }

    public function removeSessionFormationResponsable(SessionFormationResponsable $sessionFormationResponsable): self
    {
        if ($this->sessionFormationResponsables->removeElement($sessionFormationResponsable)) {
            // set the owning side to null (unless already changed)
            if ($sessionFormationResponsable->getSessionId() === $this) {
                $sessionFormationResponsable->setSessionId(null);
            }
        }

        return $this;
    }
}

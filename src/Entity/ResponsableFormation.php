<?php

namespace App\Entity;

use App\Repository\ResponsableFormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponsableFormationRepository::class)
 */
class ResponsableFormation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=responsable::class, inversedBy="responsableFormations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsable_id;

    /**
     * @ORM\ManyToOne(targetEntity=formation::class, inversedBy="responsableFormations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateformation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponsableId(): ?responsable
    {
        return $this->responsable_id;
    }

    public function setResponsableId(?responsable $responsable_id): self
    {
        $this->responsable_id = $responsable_id;

        return $this;
    }

    public function getFormationId(): ?formation
    {
        return $this->formation_id;
    }

    public function setFormationId(?formation $formation_id): self
    {
        $this->formation_id = $formation_id;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDateformation(): ?string
    {
        return $this->dateformation;
    }

    public function setDateformation(?string $dateformation): self
    {
        $this->dateformation = $dateformation;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getIdentification(): ?string
    {
        return $this->identification;
    }

    public function setIdentification(?string $identification): self
    {
        $this->identification = $identification;

        return $this;
    }
}

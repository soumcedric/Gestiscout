<?php

namespace App\Entity;

use App\Repository\SensRubriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SensRubriqueRepository::class)
 */
class SensRubrique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $Sens;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    public function getSens(): ?string
    {
        return $this->Sens;
    }

    public function setSens(string $Sens): self
    {
        $this->Sens = $Sens;

        return $this;
    }
}

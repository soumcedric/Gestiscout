<?php

namespace App\Entity;

use App\Repository\RubriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RubriqueRepository::class)
 */
class Rubrique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Code;

    /**
     * @ORM\Column(type="string", length=50)
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

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
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

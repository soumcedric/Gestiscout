<?php

namespace App\Entity;

use App\Repository\TypeMouvementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TypeMouvementRepository::class)
 */
class TypeMouvement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"typemvt"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"typemvt"})
     */
    private $Libelle;

    /**
     * @ORM\Column(type="string", length=1)
     * @Groups({"typemvt"})
     */
    private $Code;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"typemvt"})
     */
    private $datecreate;

    /**
     * @ORM\Column(type="integer")
     */
    private $usercreate;

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

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

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

    public function getUsercreate(): ?int
    {
        return $this->usercreate;
    }

    public function setUsercreate(int $usercreate): self
    {
        $this->usercreate = $usercreate;

        return $this;
    }
}
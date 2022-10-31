<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentsRepository::class)
 */
class Documents
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Extension;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DirectoryPath;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserCreation;

    /**
     * @ORM\ManyToOne(targetEntity=TypeDocument::class, inversedBy="TypeDocument")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeDocument;

    /**
     * @ORM\ManyToOne(targetEntity=Activites::class, inversedBy="documents")
     */
    private $Activite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->Extension;
    }

    public function setExtension(?string $Extension): self
    {
        $this->Extension = $Extension;

        return $this;
    }

    public function getDirectoryPath(): ?string
    {
        return $this->DirectoryPath;
    }

    public function setDirectoryPath(string $DirectoryPath): self
    {
        $this->DirectoryPath = $DirectoryPath;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->DateCreate;
    }

    public function setDateCreate(\DateTimeInterface $DateCreate): self
    {
        $this->DateCreate = $DateCreate;

        return $this;
    }

    public function getUserCreation(): ?string
    {
        return $this->UserCreation;
    }

    public function setUserCreation(?string $UserCreation): self
    {
        $this->UserCreation = $UserCreation;

        return $this;
    }

    public function getTypeDocument(): ?TypeDocument
    {
        return $this->TypeDocument;
    }

    public function setTypeDocument(?TypeDocument $TypeDocument): self
    {
        $this->TypeDocument = $TypeDocument;

        return $this;
    }

    public function getActivite(): ?Activites
    {
        return $this->Activite;
    }

    public function setActivite(?Activites $Activite): self
    {
        $this->Activite = $Activite;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TypeDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeDocumentRepository::class)
 */
class TypeDocument
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
     * @ORM\Column(type="datetime")
     */
    private $DateCreate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Bactif;

    /**
     * @ORM\OneToMany(targetEntity=Documents::class, mappedBy="TypeDocument")
     */
    private $TypeDocument;

    public function __construct()
    {
        $this->TypeDocument = new ArrayCollection();
    }

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

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->DateCreate;
    }

    public function setDateCreate(\DateTimeInterface $DateCreate): self
    {
        $this->DateCreate = $DateCreate;

        return $this;
    }

    public function getBactif(): ?bool
    {
        return $this->Bactif;
    }

    public function setBactif(bool $Bactif): self
    {
        $this->Bactif = $Bactif;

        return $this;
    }

    /**
     * @return Collection|Documents[]
     */
    public function getTypeDocument(): Collection
    {
        return $this->TypeDocument;
    }

    public function addTypeDocument(Documents $typeDocument): self
    {
        if (!$this->TypeDocument->contains($typeDocument)) {
            $this->TypeDocument[] = $typeDocument;
            $typeDocument->setTypeDocument($this);
        }

        return $this;
    }

    public function removeTypeDocument(Documents $typeDocument): self
    {
        if ($this->TypeDocument->removeElement($typeDocument)) {
            // set the owning side to null (unless already changed)
            if ($typeDocument->getTypeDocument() === $this) {
                $typeDocument->setTypeDocument(null);
            }
        }

        return $this;
    }
}

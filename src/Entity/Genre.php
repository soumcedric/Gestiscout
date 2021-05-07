<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"genre"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"genre"})
     */
    private $Libelle;


    /**
     * @ORM\OneToMany(targetEntity=Responsable::class, mappedBy="Genre")
     */
    private $responsables;

    /**
     * @ORM\OneToMany(targetEntity=JEUNE::class, mappedBy="Genre")
     */
    private $Jeunes;

    public function __construct()
    {
        $this->responsables = new ArrayCollection();
        $this->Jeunes = new ArrayCollection();
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

    public function getJeunes(): ?JEUNE
    {
        return $this->Jeunes;
    }

    public function setJeunes(JEUNE $Jeunes): self
    {
        // set the owning side of the relation if necessary
        if ($Jeunes->getGenre() !== $this) {
            $Jeunes->setGenre($this);
        }

        $this->Jeunes = $Jeunes;

        return $this;
    }

    /**
     * @return Collection|Responsable[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
            $responsable->setGenre($this);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): self
    {
        if ($this->responsables->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getGenre() === $this) {
                $responsable->setGenre(null);
            }
        }

        return $this;
    }

    public function addJeune(JEUNE $jeune): self
    {
        if (!$this->Jeunes->contains($jeune)) {
            $this->Jeunes[] = $jeune;
            $jeune->setGenre($this);
        }

        return $this;
    }

    public function removeJeune(JEUNE $jeune): self
    {
        if ($this->Jeunes->removeElement($jeune)) {
            // set the owning side to null (unless already changed)
            if ($jeune->getGenre() === $this) {
                $jeune->setGenre(null);
            }
        }

        return $this;
    }
}

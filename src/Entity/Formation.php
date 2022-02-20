<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups("formation")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("formation")
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     *  @Groups("formation")
     */
    private $ordre;

    /**
     * @ORM\ManyToMany(targetEntity=Responsable::class, inversedBy="formations")
     */
    private $responsable;

    /**
     * @ORM\OneToMany(targetEntity=ResponsableFormation::class, mappedBy="formation_id")
     */
    private $responsableFormations;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
        $this->responsableFormations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return Collection|responsable[]
     */
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(responsable $responsable): self
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable[] = $responsable;
        }

        return $this;
    }

    public function removeResponsable(responsable $responsable): self
    {
        $this->responsable->removeElement($responsable);

        return $this;
    }

    /**
     * @return Collection|ResponsableFormation[]
     */
    public function getResponsableFormations(): Collection
    {
        return $this->responsableFormations;
    }

    public function addResponsableFormation(ResponsableFormation $responsableFormation): self
    {
        if (!$this->responsableFormations->contains($responsableFormation)) {
            $this->responsableFormations[] = $responsableFormation;
            $responsableFormation->setFormationId($this);
        }

        return $this;
    }

    public function removeResponsableFormation(ResponsableFormation $responsableFormation): self
    {
        if ($this->responsableFormations->removeElement($responsableFormation)) {
            // set the owning side to null (unless already changed)
            if ($responsableFormation->getFormationId() === $this) {
                $responsableFormation->setFormationId(null);
            }
        }

        return $this;
    }
}

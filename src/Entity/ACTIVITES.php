<?php

namespace App\Entity;

use App\Repository\ACTIVITESRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ACTIVITESRepository::class)
 */
class ACTIVITES
{

    const INITIER = 0;
    const ACCEPTER =1;
    const STATUT_REFUSE =2;
    







    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("activite")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Groups("activite")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Groups("activite")
     */
    private $Localisation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("activite")
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("activite")
     */
    private $Commune;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("activite")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("activite")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Groups("activite")
     */
    private $HeureDebut;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Groups("activite")
     */
    private $HeureFin;

    /**
     * @ORM\Column(type="integer")
     * @Groups("activite")
     */
    private $Statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("activite")
     */
    private $Autorisation;

    /**
     * @ORM\Column(type="integer")
     * @Groups("activite")
     */
    private $NbreParticipant;

    /**
     * @ORM\Column(type="integer")
     * @Groups("activite")
     */
    private $Prix;

    /**
     * @ORM\OneToMany(targetEntity=DETAILS::class, mappedBy="Activite")
     * @Groups("activite")
     */
    private $Details;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="Activities")
     * @Groups("activite")
     */
    private $Groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Branche::class, inversedBy="Activities")
     * @Groups("activite")
     */
    private $Branche;

    /**
     * @ORM\OneToMany(targetEntity=MAITRISE::class, mappedBy="Activite")
     * @Groups("activite")
     */
    private $Responsable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("activite")
     */
    private $Nom;
 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Commentaire;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateValidation;

    /**
     * @ORM\ManyToOne(targetEntity=AnneePastorale::class, inversedBy="activites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anneepastorale;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserModification;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Bactif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Cible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bOneDay;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bSoumis;

    public function __construct()
    {
        $this->Details = new ArrayCollection();
        $this->Responsable = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getStautString(): ?string
    {
        return $this->StatutString;
    }



    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->Localisation;
    }

    public function setLocalisation(?string $Localisation): self
    {
        $this->Localisation = $Localisation;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->Commune;
    }

    public function setCommune(?string $Commune): self
    {
        $this->Commune = $Commune;

        return $this;
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

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->HeureDebut;
    }

    public function setHeureDebut(?\DateTimeInterface $HeureDebut): self
    {
        $this->HeureDebut = $HeureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->HeureFin;
    }

    public function setHeureFin(?\DateTimeInterface $HeureFin): self
    {
        $this->HeureFin = $HeureFin;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->Statut;
    }

    public function setStatut(int $Statut): self
    {
        
        $this->Statut = $Statut;

        return $this;
    }

    public function getAutorisation(): ?string
    {
        return $this->Autorisation;
    }

    public function setAutorisation(?string $Autorisation): self
    {
        $this->Autorisation = $Autorisation;

        return $this;
    }

    public function getNbreParticipant(): ?int
    {
        return $this->NbreParticipant;
    }

    public function setNbreParticipant(int $NbreParticipant): self
    {
        $this->NbreParticipant = $NbreParticipant;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * @return Collection|DETAILS[]
     */
    public function getDetails(): Collection
    {
        return $this->Details;
    }

    public function addDetail(DETAILS $detail): self
    {
        if (!$this->Details->contains($detail)) {
            $this->Details[] = $detail;
            $detail->setActivite($this);
        }

        return $this;
    }

    public function removeDetail(DETAILS $detail): self
    {
        if ($this->Details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getActivite() === $this) {
                $detail->setActivite(null);
            }
        }

        return $this;
    }

    public function getGroupe(): ?GROUPE
    {
        return $this->Groupe;
    }

    public function setGroupe(?GROUPE $Groupe): self
    {
        $this->Groupe = $Groupe;

        return $this;
    }

    public function getBranche(): ?Branche
    {
        return $this->Branche;
    }

    public function setBranche(?Branche $Branche): self
    {
        $this->Branche = $Branche;

        return $this;
    }

    /**
     * @return Collection|MAITRISE[]
     */
    public function getResponsable(): Collection
    {
        return $this->Responsable;
    }

    public function addResponsable(MAITRISE $responsable): self
    {
        if (!$this->Responsable->contains($responsable)) {
            $this->Responsable[] = $responsable;
            $responsable->setActivite($this);
        }

        return $this;
    }

    public function removeResponsable(MAITRISE $responsable): self
    {
        if ($this->Responsable->removeElement($responsable)) {
            // set the owning side to null (unless already changed)
            if ($responsable->getActivite() === $this) {
                $responsable->setActivite(null);
            }
        }

        return $this;
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

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->DateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $DateValidation): self
    {
        $this->DateValidation = $DateValidation;

        return $this;
    }

    public function getAnneepastorale(): ?AnneePastorale
    {
        return $this->anneepastorale;
    }

    public function setAnneepastorale(?AnneePastorale $anneepastorale): self
    {
        $this->anneepastorale = $anneepastorale;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->DateModification;
    }

    public function setDateModification(?\DateTimeInterface $DateModification): self
    {
        $this->DateModification = $DateModification;

        return $this;
    }

    public function getUserModification(): ?string
    {
        return $this->UserModification;
    }

    public function setUserModification(?string $UserModification): self
    {
        $this->UserModification = $UserModification;

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

    public function getCible(): ?string
    {
        return $this->Cible;
    }

    public function setCible(string $Cible): self
    {
        $this->Cible = $Cible;

        return $this;
    }

    public function getBOneDay(): ?bool
    {
        return $this->bOneDay;
    }

    public function setBOneDay(bool $bOneDay): self
    {
        $this->bOneDay = $bOneDay;

        return $this;
    }

    public function getBSoumis(): ?bool
    {
        return $this->bSoumis;
    }

    public function setBSoumis(bool $bSoumis): self
    {
        $this->bSoumis = $bSoumis;

        return $this;
    }
}

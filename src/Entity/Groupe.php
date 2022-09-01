<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe"})
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe"})
     */
    private $NickName;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups({"groupe"})
     * @Groups({"groupe"})
     */
    private $Phone1;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups({"groupe"})
     */
    private $Phone2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"groupe"})
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"groupe"})
     */
    private $Logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Slogan;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"groupe"})
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe"})
     */
    private $Paroisse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe"})
     */
    private $Region;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="groupe")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=JEUNE::class, mappedBy="Groupe")
     */
    private $Jeunes;

    /**
     * @ORM\OneToMany(targetEntity=ACTIVITES::class, mappedBy="Groupe")
     */
    private $Activities;

    /**
     * @ORM\ManyToOne(targetEntity=CommissariatDistrict::class, inversedBy="groupes")
     * @Groups({"groupe"})
     */
    private $commissariatDistrict;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"groupe"})
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filebase;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $filebasetext;
    /**
     * @Groups({"groupe"})
     */
    private $GroupeId;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->Jeunes = new ArrayCollection();
        $this->Activities = new ArrayCollection();
    }

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

    public function getNickName(): ?string
    {
        return $this->NickName;
    }

    public function setNickName(string $NickName): self
    {
        $this->NickName = $NickName;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->Phone1;
    }

    public function setPhone1(?string $Phone1): self
    {
        $this->Phone1 = $Phone1;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->Phone2;
    }

    public function setPhone2(?string $Phone2): self
    {
        $this->Phone2 = $Phone2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(?string $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->Slogan;
    }

    public function setSlogan(?string $Slogan): self
    {
        $this->Slogan = $Slogan;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
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

    public function getParoisse(): ?string
    {
        return $this->Paroisse;
    }

    public function setParoisse(string $Paroisse): self
    {
        $this->Paroisse = $Paroisse;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->Region;
    }

    public function setRegion(string $Region): self
    {
        $this->Region = $Region;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGroupe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGroupe() === $this) {
                $user->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|JEUNE[]
     */
    public function getJeunes(): Collection
    {
        return $this->Jeunes;
    }

    public function addJeune(JEUNE $jeune): self
    {
        if (!$this->Jeunes->contains($jeune)) {
            $this->Jeunes[] = $jeune;
            $jeune->setGroupe($this);
        }

        return $this;
    }

    public function removeJeune(JEUNE $jeune): self
    {
        if ($this->Jeunes->removeElement($jeune)) {
            // set the owning side to null (unless already changed)
            if ($jeune->getGroupe() === $this) {
                $jeune->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ACTIVITES[]
     */
    public function getActivities(): Collection
    {
        return $this->Activities;
    }

    public function addActivity(ACTIVITES $activity): self
    {
        if (!$this->Activities->contains($activity)) {
            $this->Activities[] = $activity;
            $activity->setGroupe($this);
        }

        return $this;
    }

    public function removeActivity(ACTIVITES $activity): self
    {
        if ($this->Activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getGroupe() === $this) {
                $activity->setGroupe(null);
            }
        }

        return $this;
    }

    public function getCommissariatDistrict(): ?CommissariatDistrict
    {
        return $this->commissariatDistrict;
    }

    public function setCommissariatDistrict(?CommissariatDistrict $commissariatDistrict): self
    {
        $this->commissariatDistrict = $commissariatDistrict;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getFilebase(): ?string
    {
        return $this->filebase;
    }

    public function setFilebase(?string $filebase): self
    {
        $this->filebase = $filebase;

        return $this;
    }

    public function getFilebasetext(): ?string
    {
        return $this->filebasetext;
    }

    public function setFilebasetext(?string $filebasetext): self
    {
        $this->filebasetext = $filebasetext;

        return $this;
    }



    public function setGroupeId(?int $groupeid): self
    {
        $this->GroupeId = $groupeid;

        return $this;
    }

    public function getGroupeId(): ?int
    {
        return $this->GroupeId;
    }

}

<?php

namespace App\Entity;

use App\Repository\CommissariatDistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommissariatDistrictRepository::class)
 */
class CommissariatDistrict
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("dst")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("dst")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("dst")
     */
    private $nickname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $usercreation;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="commissariatDistrict")
     */
    private $groupes;

    // /**
    // //  * @ORM\OneToMany(targetEntity=User::class, mappedBy="commissariatDistrictId")
    // *@ORM\OneToMany(targetEntity=User::class)
    //  */
    // private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("dst")
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups("dst")    
     */
    private $Telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("dst")     
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=District::class, mappedBy="CommissariatDistrict")
     */
    private $districts;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->districts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

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

    public function getUsercreation(): ?\DateTimeInterface
    {
        return $this->usercreation;
    }

    public function setUsercreation(?\DateTimeInterface $usercreation): self
    {
        $this->usercreation = $usercreation;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setCommissariatDistrict($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getCommissariatDistrict() === $this) {
                $groupe->setCommissariatDistrict(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection|User[]
    //  */
    // public function getUsers(): Collection
    // {
    //     return $this->users;
    // }

    // public function addUser(User $user): self
    // {
    //     if (!$this->users->contains($user)) {
    //         $this->users[] = $user;
    //         $user->setCommissariatDistrictId($this);
    //     }

    //     return $this;
    // }

    // public function removeUser(User $user): self
    // {
    //     if ($this->users->removeElement($user)) {
    //         // set the owning side to null (unless already changed)
    //         if ($user->getCommissariatDistrictId() === $this) {
    //             $user->setCommissariatDistrictId(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|District[]
     */
    public function getDistricts(): Collection
    {
        return $this->districts;
    }

    public function addDistrict(District $district): self
    {
        if (!$this->districts->contains($district)) {
            $this->districts[] = $district;
            $district->setCommissariatDistrict($this);
        }

        return $this;
    }

    public function removeDistrict(District $district): self
    {
        if ($this->districts->removeElement($district)) {
            // set the owning side to null (unless already changed)
            if ($district->getCommissariatDistrict() === $this) {
                $district->setCommissariatDistrict(null);
            }
        }

        return $this;
    }
}

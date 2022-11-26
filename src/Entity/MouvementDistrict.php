<?php

namespace App\Entity;

use App\Repository\MouvementDistrictRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=MouvementDistrictRepository::class)
 */
class MouvementDistrict
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("mvtdistrict")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("mvtdistrict")
     */
    private $DateMvt;

    /**
     * @ORM\Column(type="bigint")
     * @Groups("mvtdistrict")
     */
    private $Montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("mvtdistrict")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="integer")
     * @Groups("mvtdistrict")
     */
    private $usercreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("mvtdistrict")
     */
    private $datemodification;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usermodifcation;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMouvement::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("mvtdistrict")
     */
    private $typemouvement;

    /**
     * @ORM\ManyToOne(targetEntity=caissedistrict::class,cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups("mvtdistrict")
     */
    private $caisse;

    /**
     * @ORM\ManyToOne(targetEntity=Periode::class,cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups("mvtdistrict")
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity=user::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("mvtdistrict")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=District::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("mvtdistrict")
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("mvtdistrict")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMvt(): ?\DateTimeInterface
    {
        return $this->DateMvt;
    }

    public function setDateMvt(\DateTimeInterface $DateMvt): self
    {
        $this->DateMvt = $DateMvt;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): self
    {
        $this->Montant = $Montant;

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

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getUsermodifcation(): ?int
    {
        return $this->usermodifcation;
    }

    public function setUsermodifcation(?int $usermodifcation): self
    {
        $this->usermodifcation = $usermodifcation;

        return $this;
    }

    public function getTypemouvement(): ?typemouvement
    {
        return $this->typemouvement;
    }

    public function setTypemouvement(?typemouvement $typemouvement): self
    {
        $this->typemouvement = $typemouvement;

        return $this;
    }

    public function getCaisse(): ?caissedistrict
    {
        return $this->caisse;
    }

    public function setCaisse(?caissedistrict $caisse): self
    {
        $this->caisse = $caisse;

        return $this;
    }

    public function getPeriode(): ?periode
    {
        return $this->periode;
    }

    public function setPeriode(?periode $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

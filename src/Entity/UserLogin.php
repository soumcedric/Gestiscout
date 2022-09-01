<?php

namespace App\Entity;

use App\Repository\UserRepository;
// use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Security\Core\User\UserInterface;


class UserLogin
{
   
    private $id;

  
    private $username;

  
    private $roles = [];

 
    private $password;


    private $groupe;

    
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


    public function getGrou(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }
    
}

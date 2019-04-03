<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupsRepository")
 */
class Groups
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="groups")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addUser(Users $user): self
    {
        $this->users[] = $user;

        return $this;
    }

    public function removeUser(Users $user): bool
    {
        return $this->users->removeElement($user);
    }

    //returns true if user already in group
    public function checkUser(Users $user): bool
    {
        return $this->users->contains($user);
    }

    //returns true if empty
    public function noUsers(): bool
    {
        return $this->users->isEmpty();
    }
}

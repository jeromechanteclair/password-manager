<?php

namespace App\Entity;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CrewRepository")
 */
class Crew
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CrewRole", mappedBy="User", orphanRemoval=true)
     */
    private $CrewRoles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\user", inversedBy="crews")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Date", mappedBy="crew", orphanRemoval=true)
     */
    private $date;



    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->date = new ArrayCollection();

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

    /**
     * @return Collection|user[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Array $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(user $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Date[]
     */
    public function getDate(): Collection
    {
        return $this->date;
    }

    public function addDate(Date $date): self
    {
        if (!$this->date->contains($date)) {
            $this->date[] = $date;
            $date->setCrew($this);
        }

        return $this;
    }

    public function removeDate(Date $date): self
    {
        if ($this->date->contains($date)) {
            $this->date->removeElement($date);
            // set the owning side to null (unless already changed)
            if ($date->getCrew() === $this) {
                $date->setCrew(null);
            }
        }

        return $this;
    }


}

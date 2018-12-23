<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CrewRoleRepository")
 */
class CrewRole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crew;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="CrewRoles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

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

    public function getCrew(): ?Crew
    {
        return $this->crew;
    }

    public function setCrew(?Crew $crew): self
    {
        $this->crew = $crew;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
    /**
     * @return Collection|CrewRole[]
     */
    public function getCrewRoles(): Collection
    {
        return $this->CrewRoles;
    }

    public function addCrewRole(CrewRole $crewRole): self
    {
        if (!$this->CrewRoles->contains($crewRole)) {
            $this->CrewRoles[] = $crewRole;
            $crewRole->setUserId($this);
        }

        return $this;
    }

    public function removeCrewRole(CrewRole $crewRole): self
    {
        if ($this->CrewRoles->contains($crewRole)) {
            $this->CrewRoles->removeElement($crewRole);
            // set the owning side to null (unless already changed)
            if ($crewRole->getUserId() === $this) {
                $crewRole->setUserId(null);
            }
        }

        return $this;
    }
}

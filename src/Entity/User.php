<?php

namespace App\Entity;


use App\Entity\Crew;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"list"})
     */
    protected $id;
    /**
    * @Serializer\Groups({"list"})
    */
    protected $username;
    /**
    * @Serializer\Groups({"list"})
    */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crew", mappedBy="users")
     * @Serializer\Groups({"list"})
     */
    private $crews;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CrewRole", mappedBy="User", orphanRemoval=true)
     */
    private $CrewRoles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Date", mappedBy="users")
     */
    private $dates;


    public function __construct()
    {
        parent::__construct();
        // your own logic
      //  $this->addRole("ROLE_ADMIN");
        $this->crews = new ArrayCollection();
        $this->CrewRoles = new ArrayCollection();
        $this->dates = new ArrayCollection();

    }

    /**
     * @return Collection|Crew[]
     */
    public function getCrews(): Collection
    {
        return $this->crews;
    }

    public function addCrew(Crew $crew): self
    {
        if (!$this->crews->contains($crew)) {
            $this->crews[] = $crew;
            $crew->addUser($this);
        }

        return $this;
    }

    public function removeCrew(Crew $crew): self
    {
        if ($this->crews->contains($crew)) {
            $this->crews->removeElement($crew);
            $crew->removeUser($this);
        }

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Date[]
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(Date $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates[] = $date;
            $date->addUser($this);
        }

        return $this;
    }

    public function removeDate(Date $date): self
    {
        if ($this->dates->contains($date)) {
            $this->dates->removeElement($date);
            $date->removeUser($this);
        }

        return $this;
    }
}

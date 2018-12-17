<?php

namespace App\Entity;


use App\Entity\Crew;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     */
    protected $id;



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crew", mappedBy="users")
     */
    private $crews;


    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->addRole("ROLE_ADMIN");
        $this->crews = new ArrayCollection();

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
}

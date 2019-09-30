<?php

namespace App\Entity;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Reaction", mappedBy="User")
     */
    private $USer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="User")
     */
    private $User;

    public function __construct()
    {
        parent::__construct();
        $this->USer = new ArrayCollection();
        $this->User = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getUSer(): Collection
    {
        return $this->USer;
    }

    public function addUSer(Reaction $uSer): self
    {
        if (!$this->USer->contains($uSer)) {
            $this->USer[] = $uSer;
            $uSer->setUser($this);
        }

        return $this;
    }

    public function removeUSer(Reaction $uSer): self
    {
        if ($this->USer->contains($uSer)) {
            $this->USer->removeElement($uSer);
            // set the owning side to null (unless already changed)
            if ($uSer->getUser() === $this) {
                $uSer->setUser(null);
            }
        }

        return $this;
    }
}
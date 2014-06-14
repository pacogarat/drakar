<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drakkar\TestBundle\Entity\Role
 * @ORM\Table(name="role")
 * @ORM\Entity()
 */
class Role
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
 
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $role;
    
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function getRole() {
        return $this->role;
    }
   
    public function getId() {
        return $this->id;
    }
}
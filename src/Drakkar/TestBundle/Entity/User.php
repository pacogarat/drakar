<?php

namespace Drakkar\TestBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Drakkar\TestBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Drakkar\TestBundle\Entity\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     errorPath="username",
 *     message="Ya existe un usuario con ese nombre o email"
 * )
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=FALSE)
     */
    protected $role;

    /**
     * One user can have many advices
     * Owner is Advice
     * @ORM\OneToMany(targetEntity="\Drakkar\TestBundle\Entity\Advice", mappedBy="user")
     */
    protected $advices;
    
    /**
     * One user can have many orders
     * Owner is Order
     * @ORM\OneToMany(targetEntity="\Drakkar\TestBundle\Entity\Order", mappedBy="user")
     */
    protected $orders;
    
    public function __construct()
    {
        $this->isActive = true;
        $this->advices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getRole()
    {
        return array($this->role);
    }
    
    public function getRoles()
    {
        return array($this->role->getRole());
    }
    
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getAdvices() {
        return $this->advices;
    }
    
    public function setAdvices($advices) {
        $this->advices = $advices;
        return $this;
    }
    
    public function eraseCredentials()
    {
    }

    public function getOrders() {
        return $this->orders;
    }
    
    public function setOrders($orders) {
        $this->orders = $orders;
        return $this;
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }
}
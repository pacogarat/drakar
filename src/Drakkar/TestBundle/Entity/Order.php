<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Drakkar\TestBundle\Entity\Order
 * @ORM\Table(name="order_item")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Drakkar\TestBundle\Entity\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Many orders have one user
     *
     * @ORM\ManyToOne(targetEntity="\Drakkar\TestBundle\Entity\User", inversedBy="orders")
     */
    protected $user;

    /**
     * Many orders have one item
     *
     * @ORM\ManyToOne(targetEntity="\Drakkar\TestBundle\Entity\Item", inversedBy="orders")
     */
    protected $item;
    
    /**
     * @ORM\Column(type="datetime", unique=false, nullable=false)
     */
    private $created_at;
    
    public function __construct() {
        $this->created_at = new \DateTime();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
        return $this;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }
    
    public function getItem() {
        return $this->item;
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public function setItem($item) {
        $this->item = $item;
        return $this;
    }
}
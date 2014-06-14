<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Drakkar\TestBundle\Entity\Item
 * @ORM\Table(name="item")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Drakkar\TestBundle\Entity\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120, unique=false)
     */
    private $title;
    
    /**
     * @ORM\Column(type="boolean", unique=false)
     */
    private $active;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "El precio debe ser positivo"
     * )
     */
    private $price;
    
    /**
     * @ORM\Column(type="string", length=120, unique=false)
     */
    private $description;
    
    /**
     * One item can have many advices
     * Owner is Advice
     * @ORM\OneToMany(targetEntity="\Drakkar\TestBundle\Entity\Advice", mappedBy="item")
     */
    protected $advices;
    
    /**
     * One item can have many orders
     * Owner is Order
     * @ORM\OneToMany(targetEntity="\Drakkar\TestBundle\Entity\Order", mappedBy="item")
     */
    protected $orders;
    
    public function __construct() {
        $this->active = true;
        $this->advices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title=$title;
    }
    
    public function getActive() {
        return $this->active;
    }
    
    public function setActive($active) {
        $this->active=$active;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function setPrice($price) {
        $this->price=$price;
    }
    
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getAdvices() {
        return $this->advices;
    }
    
    public function setAdvices($advices) {
        $this->advices = $advices;
        return $this;
    }
    
    public function getOrders() {
        return $this->orders;
    }
    
    public function setOrders($orders) {
        $this->orders = $orders;
        return $this;
    }
}
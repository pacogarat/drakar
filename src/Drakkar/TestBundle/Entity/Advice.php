<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Drakkar\TestBundle\Entity\Advice
 * @ORM\Table(name="advice")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Drakkar\TestBundle\Entity\AdviceRepository")
 * @UniqueEntity(
 *     fields={"item", "user"},
 *     errorPath="user",
 *     message="Ya existe la recomendación"
 * )
 */
class Advice
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Many advices have one user
     *
     * @ORM\ManyToOne(targetEntity="\Drakkar\TestBundle\Entity\User", inversedBy="advices")
     */
    protected $user;

    /**
     * Many advices have one item
     *
     * @ORM\ManyToOne(targetEntity="\Drakkar\TestBundle\Entity\Item", inversedBy="advices")
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
<?php

namespace Drakkar\TestBundle\Model;

class ShirtDispatcher
{
    
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function getItems($user,$pagination) {
        if (key_exists('page', $pagination) && $pagination['page']>0) {
            $page = $pagination['page'];
        } else {
            $page = 1;
        }
        $items = $this->em->getRepository('DrakkarTestBundle:Item')->getItemsForUser($user, $page);
        return $items;
    }
    
    public function getDiscountForUser($user) {
        $count_advices = $this->em->getRepository('DrakkarTestBundle:Advice')->getTotalAdvices($user);
        $discount = ($count_advices>5)?5:0;
        $count_orders = $this->em->getRepository('DrakkarTestBundle:Order')->getMonthOrders($user);
        $discount += ($count_orders>=2)?2:0;
        return $discount;
    }
    
    public function orderItem($user, $item) {
        $order = new \Drakkar\TestBundle\Entity\Order();
        $order->setUser($user);
        $order->setItem($item);
        $this->em->persist($order);
        $this->em->flush();
        return true;
    }
}
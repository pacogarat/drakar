<?php

namespace Drakkar\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Drakkar\TestBundle\Entity\Item;

/**
 * @Route("/shirt")
 */
class ShirtController extends Controller
{
    /**
     * @Route("/", name="drakkar_index")
     * @Route("/{page}", name="drakkar_index_paginated")
     * @Template()
     */
    public function indexAction($page=null)
    {
        $page = (empty($page))?1:$page;
        $item_dispatcher = $this->get('drakkar.item.dispatcher');
        $items = $item_dispatcher->getItems($this->getUser(),array('page'=>$page));
        return array(
            'items' => $items,
            'page' => $page
                );
    }
    
    /**
     * @Route("/detail/{id}", name="drakkar_item_detail")
     * @ParamConverter("id", class="DrakkarTestBundle:Item")
     * @Template()
     */
    public function detailAction(Item $item)
    {
        $shirt_dispatcher = $this->get('drakkar.item.dispatcher');
        $discount = $shirt_dispatcher->getDiscountForUser($this->getUser()); 
        $price = $item->getPrice() * ((100 - $discount)/100);
        return array(
            'item' => $item,
            'discount' => $discount,
            'price' => $price
                );
    }
    
    /**
     * @Route("/buy/{id}", name="drakkar_item_buy")
     * @ParamConverter("id", class="DrakkarTestBundle:Item")
     * @Template()
     */
    public function buyAction(Item $item)
    {
        $shirt_dispatcher = $this->get('drakkar.item.dispatcher');
        $shirt_dispatcher->orderItem($this->getUser(), $item);
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Compra efectuada'
        );
        return $this->redirect($this->generateUrl('drakkar_index'));
    }
}
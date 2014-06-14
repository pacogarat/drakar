<?php

namespace Drakkar\TestBundle\Model;

class AdviceDispatcher
{
    const ITEMS_PER_PAGE = 10;
    
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAdvices($user, $pagination) {
        if (key_exists('page', $pagination) && $pagination['page']>0) {
            $page = $pagination['page'];
        } else {
            $page = 1;
        }
        $advices = $this->em->getRepository('DrakkarTestBundle:Advice')->findBy(
                array('user' => $user),
                array(),
                    self::ITEMS_PER_PAGE, // limit
                    5 * ($page - 1) // offset
                );
        return $advices;
    }
}
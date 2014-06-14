<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ItemRepository extends EntityRepository
{
    const ITEMS_PER_PAGE = 10;

    public function getItemsForUser($user, $page) {
        $offset = ($page - 1)*self::ITEMS_PER_PAGE;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('description', 'description');
        $rsm->addScalarResult('price', 'price');
        $rsm->addScalarResult('created_at', 'created_at');
        $sql =  'select i.*, temp.created_at from item i '.
                'left join '.
                    '(select * '. 
                    'from advice a '. 
                    'where a.user_id=:user_id) temp '. 
                'on temp.item_id=i.id '.
                'limit '.self::ITEMS_PER_PAGE.' offset :offset';
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm)
                    ->setParameter(':user_id', $user->getId())
                    ->setParameter(':offset', $offset);
        return $query->getResult();
    }
}
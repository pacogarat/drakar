<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class OrderRepository extends EntityRepository
{
    const DISCOUNT_MONTH = "06";
    
    public function getMonthOrders($user) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('total', 'total');
        $sql =  'select count(*) as total '.
                'from order_item o '.
                'where date_format(o.created_at,"%m") = :month '.
                ' and o.user_id = :user_id';
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm)
                    ->setParameter(':user_id', $user->getId())
                    ->setParameter(':month', self::DISCOUNT_MONTH);
        $result = $query->getResult();
        if (count($result) > 0 && key_exists('total', $result[0])) {
            return $result[0]['total'];
        }
        return 0;
     }
}
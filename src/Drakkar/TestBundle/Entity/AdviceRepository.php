<?php

namespace Drakkar\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class AdviceRepository extends EntityRepository
{
   public function getTotalAdvices($user) {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('total', 'total');
        $sql =  'select count(a.id) as total '.
                'from advice a '.
                'where user_id = :user_id ';
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm)
                    ->setParameter(':user_id', $user->getId());
        $result = $query->getResult();
        if (count($result) > 0 && key_exists('total', $result[0])) {
            return $result[0]['total'];
        }
        return 0;
    }
}
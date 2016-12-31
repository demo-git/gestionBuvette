<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OperationRepository extends EntityRepository
{
    public function getQuery($type = null) {
         $qb = $this->createQueryBuilder('o');
        if ($type !== null) {
            $qb->where('o.type = :type')
                ->setParameter('type', $type);
        }
        return $qb->getQuery();
    }
}

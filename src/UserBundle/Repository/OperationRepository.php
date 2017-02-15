<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Operation;

class OperationRepository extends EntityRepository
{
    public function getQuery($type = null) {
         $qb = $this->createQueryBuilder('o');
        if ($type !== null) {
            if ($type !== Operation::TYPE_VENTE) {
                $qb->where('o.type = :type')
                    ->setParameter('type', $type);
            } else {
                $qb->where('o.type = :type')
                    ->orWhere('o.type = :cb')
                    ->setParameter('type', $type)
                    ->setParameter('cb', Operation::TYPE_VENTE_CB);
            }
        }
        return $qb->getQuery();
    }
}

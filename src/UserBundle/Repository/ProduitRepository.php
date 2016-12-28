<?php

namespace UserBundle\Repository;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Produit;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends EntityRepository
{
    /**
     * @param int $type
     * @return array Produit
     */
    public function getBuvetteListe($type = null) {
        $qb = $this->createQueryBuilder('p')
            ->where('p.actif = 1')
            ->andWhere('p.prixVente IS NOT NULL')
            ->andWhere('p.quantiteActuelle > 0');
        if ($type !== null) {
            $qb->andWhere('p.type = :type')
                ->setParameter('type', $type);
        } else {
            $qb->andWhere('p.type != ' . Produit::TYPE_COMPOSANT);
        }
        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @return array Produit
     */
    public function getByAlerte() {
        return $this->createQueryBuilder('p')
            ->where('p.actif = 1')
            ->andWhere('p.warnThreshold >= p.quantiteActuelle')
            ->getQuery()
            ->getResult();
    }
}

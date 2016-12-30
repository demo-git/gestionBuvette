<?php

namespace BuvetteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use BuvetteBundle\Entity\Produit_panier;

class Produit_panierRepository extends EntityRepository
{
    /**
     * @return array Produit_panier
     */
    public function getCommande() {
        return $this->createQueryBuilder('pp')
            ->select('pp, p, pr')
            ->join('pp.panier', 'p')
            ->join('pp.produit', 'pr')
            ->where('pp.state = ' . Produit_panier::STATE_ATTENTE)
            ->orWhere('pp.state = ' . Produit_panier::STATE_PREPA)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array Produit_panier
     */
    public function getAlertesCommande() {
        return $this->createQueryBuilder('pp')
            ->select('pp, p, pr')
            ->join('pp.produit', 'pr')
            ->join('pp.panier', 'p')
            ->where('pp.state != ' . Produit_panier::STATE_NOWAITING)
            ->andWhere('pp.state != ' . Produit_panier::STATE_RETIRER)
            ->orderBy('pp.state', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
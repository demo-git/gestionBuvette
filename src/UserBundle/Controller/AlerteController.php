<?php

namespace UserBundle\Controller;

use BuvetteBundle\Entity\Produit_panier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Produit;
use UserBundle\Entity\Setting;

class AlerteController extends Controller
{
    /**
     * @return Response
     * @Route("/refresh/alerte/stocks", name="alerte_stock")
     */
    public function alerteStockAction()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getByAlerte();
        $json = array();
        foreach ($produits as $produit) {
            if ($produit->getQuantiteActuelle() <= $produit->getDangerThreshold()) {
                $type = 1;
            } else {
                $type = 2;
            }
            $json[] = array($produit->getId(), $produit->getNom(), $produit->getQuantiteActuelle(), $type);
        }

        return new Response(json_encode($json));
    }

    /**
     * @Route("/refresh/alerte/commandes/{type}", name="alerte_commandes")
     * @return Response
     */
    public function alerteCommandesAction($type) {
        $repo = $this->getDoctrine()->getRepository(Produit_panier::class);
        if ($type == 1) {
            $produitsPanier = $repo->getCommande();
        } else {
            $produitsPanier = $repo->getAlertesCommande();
        }
        $settings = $this->getDoctrine()->getRepository(Setting::class)->find(1);
        $jsonResponse = array(0 => array($settings->getWarningWait(), $settings->getDangerWait()), 1 => array());
        $now = new \DateTime();

        foreach ($produitsPanier as $produitPanier) {
            $diff = $now->diff($produitPanier->getPanier()->getCreateAt());
            $jsonResponse[1][] = array(
                $produitPanier->getId(),
                $produitPanier->getProduit()->getNom(),
                $produitPanier->getPanier()->getId(),
                $produitPanier->getState(),
                ($diff->d * 24 + $diff->h) * 60 + $diff->i
            );
        }

        return new Response(json_encode($jsonResponse));
    }
}
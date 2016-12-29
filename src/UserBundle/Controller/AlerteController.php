<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Produit;

class AlerteController extends Controller
{
    /**
     * @return Response
     * @Route("/refresh/alerte/stocks", name="alerte_stock")
     */
    public function indexAction()
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
}
<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Produit;

class TarifController extends Controller
{
    /**
     * @Route("/", name="buvette_tarif")
     * @return Response
     */
    public function tarifAction()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe();
        return $this->render('BuvetteBundle:tarif:tarif.html.twig', array(
            'produits' => $produits
        ));
    }

    /**
     * @Route("/reload/produits", name="refresh_produits")
     * @return Response
     */
    public function refreshProduitsAction() {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe();
        $jsonResponse = array();
        foreach ($produits as $produit) {
            $image = null;
            if ($produit->getImage()) {
                $image = $produit->getImage()->getPath();
            }
            $jsonResponse[$produit->getType()][] = array($produit->getId(), $produit->getNom(), $produit->getPrixVente(), $produit->getCuisson(), $image, $produit->getQuantiteActuelle());
        }
        return new Response(json_encode($jsonResponse));
    }

}
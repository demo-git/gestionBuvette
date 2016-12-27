<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Produit;

class TarifController extends Controller
{
    /**
     * @Route("/", name="buvette_tarif")
     */
    public function tarifAction()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe();
        return $this->render('BuvetteBundle:tarif:tarif.html.twig', array(
            'produits' => $produits
        ));
    }

}
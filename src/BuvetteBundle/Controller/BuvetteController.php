<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Produit;

class BuvetteController extends Controller
{
    /**
     * @Route("/buvette", name="buvette_commande")
     */
    public function indexAction()
    {
        $produitsD = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe(Produit::TYPE_DRINK);
        $produitsS = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe(Produit::TYPE_SNACK);
        $produitsP = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe(Produit::TYPE_PIZZA);
        $produitsSA = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe(Produit::TYPE_SANDWITCH);
        return $this->render('BuvetteBundle:Main:index.html.twig', array(
            'produitsD' => $produitsD,
            'produitsS' => $produitsS,
            'produitsSA' => $produitsSA,
            'produitsP' => $produitsP
        ));
    }

    /**
     * @Route("/", name="buvette_tarif")
     */
    public function tarifAction()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->getBuvetteListe();
        return $this->render('BuvetteBundle:Main:tarif.html.twig', array(
            'produits' => $produits
        ));
    }
}

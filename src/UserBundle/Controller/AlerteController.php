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
        return new Response(0);
    }
}
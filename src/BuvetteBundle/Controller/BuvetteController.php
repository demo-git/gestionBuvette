<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BuvetteController extends Controller
{
    /**
     * @Route("/buvette", name="buvette_commande")
     */
    public function indexAction()
    {
        return $this->render('BuvetteBundle:Main:index.html.twig');
    }

    /**
     * @Route("/", name="buvette_tarif")
     */
    public function tarifAction()
    {
        return $this->render('BuvetteBundle:Main:tarif.html.twig');
    }
}

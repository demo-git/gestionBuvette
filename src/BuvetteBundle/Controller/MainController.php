<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="buvette_accueil")
     */
    public function indexAction()
    {
        return $this->render('BuvetteBundle:Main:index.html.twig');
    }

    /**
     * @Route("/tarif", name="buvette_tarif")
     */
    public function tarifAction()
    {
        return $this->render('BuvetteBundle:Main:tarif.html.twig');
    }
}

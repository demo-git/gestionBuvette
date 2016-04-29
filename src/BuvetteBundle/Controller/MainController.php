<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="general_accueil")
     */
    public function indexAction()
    {
        return $this->render('BuvetteBundle:Main:index.html.twig');
    }
}

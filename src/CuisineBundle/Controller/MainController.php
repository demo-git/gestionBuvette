<?php

namespace CuisineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/accueil", name="cuisine_accueil")
     */
    public function indexAction()
    {
        return $this->render('CuisineBundle:Main:index.html.twig');
    }
}

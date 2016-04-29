<?php

namespace CuisineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="cuisine_accueil")
     */
    public function indexAction()
    {
        return $this->render('CuisineBundle:Main:index.html.twig');
    }
}

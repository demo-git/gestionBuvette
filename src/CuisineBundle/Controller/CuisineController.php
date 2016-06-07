<?php

namespace CuisineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CuisineController extends Controller
{
    /**
     * @Route("/cuisine", name="cuisine_commande")
     */
    public function indexAction(Request $request){
        return $this->render('CuisineBundle:Main:index.html.twig');
    }
}
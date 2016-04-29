<?php

namespace CuisineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('CuisineBundle:Main:index.html.twig');
    }
}

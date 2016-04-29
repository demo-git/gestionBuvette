<?php

namespace BuvetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('BuvetteBundle:Default:index.html.twig');
    }
}

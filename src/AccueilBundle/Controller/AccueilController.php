<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccueilController extends Controller
{
    /**
     * @Route("/accueil/billetterie", name="accueil_billetterie")
     */
    public function billetterieAction()
    {
        return $this->render('AccueilBundle:Billetterie:index.html.twig');
    }
}

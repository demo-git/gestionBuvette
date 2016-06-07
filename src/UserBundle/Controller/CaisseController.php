<?php
/**
 * Created by PhpStorm.
 * User: jérémy
 * Date: 01/06/2016
 * Time: 13:56
 */

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CaisseController extends Controller
{
    /**
     * @Route("/admin/gestioncaisse", name="admin_gestioncaisse")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Caisse:index.html.twig');
    }
}
<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Operation;
use UserBundle\Form\OperationType;

class CaisseController extends Controller
{
    /**
     * @Route("/admin/gestioncaisse", name="admin_gestioncaisse")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($operation);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Le mouvement financier a été enregistré');
            }
            else{
                $request->getSession()->getFlashBag()->add('error', 'Echec du mouvement financier');
            }
        }

        $operations = $this->getDoctrine()->getRepository(Operation::class)->findAll();

        $ca = 0;
        $total = 0;
        $benef = 0;
        foreach ($operations as $ope){
            switch($ope->getType()){
                case Operation::TYPE_AJOUT:
                    $total += $ope->getMontant();
                    break;
                case Operation::TYPE_FACTURE:
                    $benef -= $ope->getMontant();
                    $total -= $ope->getMontant();
                    break;
                case Operation::TYPE_RETRAIT:
                    $total -= $ope->getMontant();
                    break;
                case Operation::TYPE_VENTE:
                    $total += $ope->getMontant();
                    $benef += $ope->getMontant();
                    $ca += $ope->getMontant();
                    break;
            }
        }

        return $this->render('UserBundle:Caisse:index.html.twig', array('form' => $form, 'operations' => $operations, 'benef' => $benef, 'ca' => $ca, 'total' => $total));
    }
}
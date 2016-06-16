<?php
/**
 * Created by PhpStorm.
 * User: jérémy
 * Date: 24/05/2016
 * Time: 15:11
 */

namespace UserBundle\Controller;

use UserBundle\Entity\Facture;
use UserBundle\Entity\Produit;
use UserBundle\Form\FactureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FactureController extends Controller
{
    /**
     * @Route("/admin/facture/{id}", name="admin_addfacture", requirements={"id" = "\d+"}, defaults={"id" = -1})
     */
    public function ajoutAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);

        if($produit){
            $facture = new Facture();
            $facture->setProduit($produit);
            $form = $this->createForm(FactureType::class, $facture);

            if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isValid()){
                    $em->persist($facture);
                    $produit->setQuantiteActuelle($produit->getQuantiteActuelle() + $facture->getQuantite());
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'La facture a bien été créée');
                    return $this->redirect($this->generateUrl('admin_gestionproduit'));
                }
            }
        }
        else{
            $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');
            return $this->redirect($this->generateUrl('admin_gestionproduit'));
        }

        return $this->render('UserBundle:Facture:ajouter.html.twig', array('form' => $form->createView(), 'produit' => $produit));
    }
}
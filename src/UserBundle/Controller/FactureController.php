<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Facture;
use UserBundle\Entity\Operation;
use UserBundle\Entity\Produit;
use UserBundle\Form\FactureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FactureController extends Controller
{
    /**
     * @Route("/admin/facture/{id}", name="admin_addfacture", requirements={"id" = "\d+"}, defaults={"id" = -1})
     * @param Request $request
     * @param int $id
     * @return Response
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
                    $operation = new Operation();
                    $operation->setJustification('achat produit ' . $produit->getNom());
                    $operation->setType(Operation::TYPE_FACTURE);
                    $operation->setMontant($form->get('prix')->getData());
                    $facture->setOperation($operation);
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
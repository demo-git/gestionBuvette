<?php

namespace CuisineBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Produit;

class CuisineController extends Controller
{
    /**
     * @Route("/cuisine", name="cuisine_commande")
     */
    public function indexAction(Request $request) {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy(array('isBillable' => 0));
        return $this->render('CuisineBundle:Main:index.html.twig', array(
            'produits' => $produits
        ));
    }

    /**
     * @Route("/cuisine/addQuantity/{id}", name="cuisine_addquantity")
     * @ParamConverter("produit", class="UserBundle:Produit")
     */
    public function addQuantityAction(Request $request, Produit $produit) {
        if ($produit) {
            $form = $this->createFormBuilder()
                ->add('quantity', IntegerType::class, array(
                'label' => 'Quantité : ',
                'attr' => array('class' => 'form-control', 'min' => 0)
                ))
                ->add('Enregistrer', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-success margin-top-20')
                ))
                ->getForm();

            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $produit->setQuantiteActuelle($produit->getQuantiteActuelle() + $form->get('quantity')->getData());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($produit);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'La quantité a bien été modifiée');

                    if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                        return $this->redirect($this->generateUrl('admin_gestionproduit'));
                    } else {
                        return $this->redirect($this->generateUrl('cuisine_commande'));
                    }

                }
            }

            return $this->render('CuisineBundle:Main:add_quantity.html.twig', array('form' => $form->createView()));

        } else {
            $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            } else {
                return $this->redirect($this->generateUrl('cuisine_commande'));
            }
        }
    }
}
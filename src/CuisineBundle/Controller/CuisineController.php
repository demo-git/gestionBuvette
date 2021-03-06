<?php

namespace CuisineBundle\Controller;

use BuvetteBundle\Entity\Produit_panier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Produit;
use UserBundle\Entity\Setting;

class CuisineController extends Controller
{
    /**
     * @Route("/cuisine", name="cuisine_commande")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(Produit::class)->findBy(array('isBillable' => 0, 'actif' => 1));
        $produitsPanier = $em->getRepository(Produit_panier::class)->getCommande();
        $settings = $em->getRepository(Setting::class)->find(1);
        return $this->render('CuisineBundle:cuisine:index.html.twig', array(
            'produits' => $produits,
            'commandes' => $produitsPanier,
            'settings' => $settings
        ));
    }

    /**
     * @param Request $request
     * @param Produit $produit
     * @return Response
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
                    $qte = $form->get('quantity')->getData();
                    $produit->setQuantiteActuelle($produit->getQuantiteActuelle() + $qte);
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

            return $this->render('CuisineBundle:cuisine:add_quantity.html.twig', array('form' => $form->createView()));

        } else {
            $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            } else {
                return $this->redirect($this->generateUrl('cuisine_commande'));
            }
        }
    }

    /**
     * @Route("/cuisine/refresh/produits", name="cuisine_refresh_produits")
     * @return Response
     */
    public function refreshProduitsAction() {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy(array('isBillable' => 0, 'actif' => 1));
        $jsonResponse = array();
        foreach ($produits as $produit) {
            $jsonResponse[] = array($produit->getId(), $produit->getNom(), $produit->getQuantiteActuelle());
        }

        return new Response(json_encode($jsonResponse));
    }

    /**
     * @Route("/upgrade/commande", name="cuisine_upgrade_commande")
     * @param Request $request
     * @return Response
     */
    public function upgradeCommandeAction(Request $request) {

        if ($request->isMethod('POST') && $request->get('id')) {
            $em = $this->getDoctrine()->getManager();
            $panierProd = $em->getRepository(Produit_panier::class)->find($request->get('id'));

            $panierProd->setState($panierProd->getState() + 1);
            $em->flush();

            return new Response(json_encode(array($panierProd->getState(), $panierProd->getId())));
        }

        return new Response('0');
    }

}
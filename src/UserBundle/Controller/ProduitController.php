<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Produit;
use UserBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends Controller
{
    /**
     * @Route("/admin/gestionproduit", name="admin_gestionproduit")
     */
    public function indexAction()
    {
        $produits = $this->getDoctrine()->getRepository('UserBundle:Produit')->findBy(array('actif' => true));

        return $this->render('UserBundle:Produit:index.html.twig', array('produits' => $produits));
    }

    /**
     * @Route("/admin/produit/{id}", name="admin_modifierproduit", requirements={"id" = "\d+"}, defaults={"id" = -1})
     */
    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();

        if($id != -1){
            $produit = $em->getRepository('UserBundle:Produit')->find($id);
            if(!$produit){
                $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            }

        }

        $form = $this->createForm(ProduitType::class, $produit);

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                if($produit->getPathImage()){
                    $file = $produit->getPathImage();
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->container->getParameter('kernel.root_dir').'/../web/uploads/', $fileName);
                    $produit->setPathImage($fileName);
                }

                foreach ($produit->getComposants() as $composant){
                    $composant->setProduitCompose($produit);
                }

                $em->persist($produit);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été enregistré');
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            }
        }

        return $this->render('UserBundle:Produit:modifier.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/ajax/produit/actif", name="admin_ajax_produit")
     */
    public function ajaxActifAction(Request $request){
        $data = '';

        if($request->isMethod('POST')){
            $produits = $this->getDoctrine()->getRepository('UserBundle:Produit')->findBy(array('actif' => true));
            foreach ($produits as $produit){
                $data .= $produit->getId() . '/' . $produit->getNom() . ';';
            }
            $data = substr($data, 0, strlen($data) - 1);
        }

        return new Response($data);
    }

    /**
     * @Route("/admin/produit/delete/{id}", name="admin_deleteproduit", requirements={"id" = "\d+"})
     */
    public function deleteAction(Request $request, $id){
        if($id != null && $id >=0){
            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository('UserBundle:Produit')->find($id);
            $produit->setActif(false);
            foreach ($produit->getComposants() as $composant){
                $em->remove($composant);
            }
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été supprimé');
        }
        else{
            $request->getSession()->getFlashBag()->add('error', 'Le produit n\'a pas pu être supprimé');
        }

        return $this->redirect($this->generateUrl('admin_gestionproduit'));
    }
}
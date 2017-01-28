<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Image;
use UserBundle\Entity\Produit;
use UserBundle\Form\ImageType;
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
        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $produitsBoisson = $repo->findBy(array('actif' => true, 'type' => Produit::TYPE_DRINK));
        $produitsSandwitch = $repo->findBy(array('actif' => true, 'type' => Produit::TYPE_SANDWITCH));
        $produitsSnack = $repo->findBy(array('actif' => true, 'type' => Produit::TYPE_SNACK));
        $produitsPizza = $repo->findBy(array('actif' => true, 'type' => Produit::TYPE_PIZZA));
        $produitsComposant = $repo->findBy(array('actif' => true, 'type' => Produit::TYPE_COMPOSANT));

        return $this->render('UserBundle:Produit:index.html.twig', array(
            'produitsBoisson' => $produitsBoisson,
            'produitsSandwitch' => $produitsSandwitch,
            'produitsSnack' => $produitsSnack,
            'produitsPizza' => $produitsPizza,
            'produitsComposant' => $produitsComposant
        ));
    }

    /**
     * @Route("/admin/produit/image/{id}", name="admin_addimage", requirements={"id" = "\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function imageAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        if(!$produit){
            $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');
            return $this->redirect($this->generateUrl('admin_gestionproduit'));
        }

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                $file = $image->getPath();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('kernel.root_dir').'/../web/uploads/', $fileName);
                $image->setPath($fileName);

                $produit->setImage($image);

                $em->persist($produit);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'L\'image a bien été enregistré');
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            }
        }

        return $this->render('UserBundle:Image:index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/produit/{id}", name="admin_modifierproduit", requirements={"id" = "\d+"}, defaults={"id" = -1})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();

        if($id != -1){
            $produit = $em->getRepository(Produit::class)->find($id);
            if(!$produit){
                $request->getSession()->getFlashBag()->add('error', 'Le produit n\'existe pas');
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            }

        }

        $form = $this->createForm(ProduitType::class, $produit);

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid() && $produit->getType() !== null && $produit->getIsBillable() !== null){
                foreach ($produit->getComposants() as $composant){
                    $composant->setProduitCompose($produit);
                }

                $em->persist($produit);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été enregistré');
                return $this->redirect($this->generateUrl('admin_gestionproduit'));
            } else {
                $request->getSession()->getFlashBag()->add('error', 'Il faut définir un type de produit et d\'ajout');
            }
        }

        return $this->render('UserBundle:Produit:modifier.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/ajax/produit/actif", name="admin_ajax_produit")
     * @param Request $request
     * @return Response
     */
    public function ajaxActifAction(Request $request){
        $data = '';

        if($request->isMethod('POST')){
            $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy(array('actif' => true));
            foreach ($produits as $produit){
                $data .= $produit->getId() . '/' . $produit->getNom() . ';';
            }
            $data = substr($data, 0, strlen($data) - 1);
        }

        return new Response($data);
    }

    /**
     * @Route("/admin/produit/delete/{id}", name="admin_deleteproduit", requirements={"id" = "\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteAction(Request $request, $id){
        if($id != null && $id >=0){
            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository(Produit::class)->find($id);
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
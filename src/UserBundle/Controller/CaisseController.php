<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Operation;
use UserBundle\Form\OperationType;

class CaisseController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/gestioncaisse", name="admin_gestioncaisse")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = null;
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $formSearch =  $this->createFormBuilder()
            ->add('typeSearch', ChoiceType::class,array(
                'choices'  => array('Tous' => -1, 'Retrait d\'argent' => Operation::TYPE_RETRAIT, 'Dépôt d\'argent' => Operation::TYPE_AJOUT, 'Facture' => Operation::TYPE_FACTURE, 'Vente' => Operation::TYPE_VENTE),
                'expanded' => false,
                'multiple' => false,
                'attr' => array('class' => 'selectpicker'),
                'required' => true
            ))
            ->add('Filtrer', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')
            ))
            ->getForm();

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $formSearch->handleRequest($request);
            if ($form->isSubmitted()) {
                if($form->isValid()){
                    $em->persist($operation);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'Le mouvement financier a été enregistré');
                }
                else{
                    $request->getSession()->getFlashBag()->add('error', 'Echec du mouvement financier');
                }
            }

            if ($formSearch->isSubmitted() && $formSearch->isValid() && $formSearch->get('typeSearch')->getData() != -1) {
                $query = $em->getRepository(Operation::class)->getQuery($formSearch->get('typeSearch')->getData());
            }
        }

        if ($query == null) {
            $query = $em->getRepository(Operation::class)->getQuery();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            30
        );
        $operations = $em->getRepository(Operation::class)->findAll();
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

        return $this->render('UserBundle:Caisse:index.html.twig', array(
            'form' => $form->createView(),
            'pagination' => $pagination,
            'benef' => $benef,
            'ca' => $ca,
            'total' => $total,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Operation $operation
     * @return Response
     * @Route("/admin/operation/{id}", name="admin_modifieroperation")
     * @ParamConverter("operation", class="UserBundle:Operation")
     */
    public function modifierAction(Request $request, Operation $operation) {
        if ($operation) {
            $form = $this->createForm(OperationType::class, $operation);

            if ($request->isMethod('POST')) {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($operation);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('success', 'L\'opération a bien été mise à jour');
                    return $this->redirect($this->generateUrl('admin_gestioncaisse'));
                }
            }

            return $this->render('UserBundle:Caisse:modifier.html.twig', array('form' => $form->createView()));
        } else {
            $request->getSession()->getFlashBag()->add('error', 'L\'opération n\'existe pas');
            return $this->redirect($this->generateUrl('admin_gestioncaisse'));
        }
    }
}
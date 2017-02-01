<?php

namespace BuvetteBundle\Controller;

use BuvetteBundle\Entity\Panier;
use BuvetteBundle\Entity\Produit_panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Operation;
use UserBundle\Entity\Produit;

class BuvetteController extends Controller
{
    /**
     * @Route("/buvette", name="buvette_commande")
     */
    public function indexAction()
    {
        $produitRepo = $this->getDoctrine()->getRepository(Produit::class);
        $produitsD = $produitRepo->getBuvetteListe(Produit::TYPE_DRINK);
        $produitsS = $produitRepo->getBuvetteListe(Produit::TYPE_SNACK);
        $produitsP = $produitRepo->getBuvetteListe(Produit::TYPE_PIZZA);
        $produitsSA = $produitRepo->getBuvetteListe(Produit::TYPE_SANDWITCH);
        return $this->render('BuvetteBundle:buvette:index.html.twig', array(
            'produitsD' => $produitsD,
            'produitsS' => $produitsS,
            'produitsSA' => $produitsSA,
            'produitsP' => $produitsP
        ));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/buvette/commande/validation", name="buvette_validation")
     */
    public function validationAction(Request $request)
    {
        $produits = $request->get('produits');
        $prix = $request->get('prix');
        $payement = $request->get('payement');
        if ($request->isMethod('POST') && $produits != null && $prix != null && $payement != null) {
            $em = $this->getDoctrine()->getManager();
            $produitRepo = $em->getRepository(Produit::class);
            $panier = new Panier();
            $panier->setTypePayement($payement);
            $operation = new Operation();
            $operation->setMontant($prix);
            $operation->setType(Operation::TYPE_VENTE);
            $produits = json_decode($produits);

            foreach ($produits as $produit) {
                $prd = $produitRepo->find($produit[0]);
                if ($prd->getCuisson() == 0) {
                    $panier->addProduitCommande(new Produit_panier($produit[1], $panier, $prd));
                } else {
                    $x = 0;
                    while ($x < $produit[1]) {
                        $panier->addProduitCommande(new Produit_panier(1, $panier, $prd, Produit_panier::STATE_ATTENTE));
                        $x++;
                    }
                }
                $prd->setQuantiteActuelle($prd->getQuantiteActuelle() - $produit[1]);
                $operation->setJustification($operation->getJustification() . $prd->getNom() . '/');
            }

            $panier->setOperation($operation);
            $em->persist($panier);
            $em->flush();

            return new Response($panier->getId());
        }

        return new Response('0');
    }
}

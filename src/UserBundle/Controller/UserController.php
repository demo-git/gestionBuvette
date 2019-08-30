<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Setting;
use UserBundle\Form\SettingType;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $checker = $this->get('security.authorization_checker');
        if ($checker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if($checker->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('admin_gestionproduit');
            } elseif ($checker->isGranted('ROLE_CUISINE')){
                return $this->redirectToRoute('cuisine_commande');
            } elseif ($checker->isGranted('ROLE_BUVETTE')){
                return $this->redirectToRoute('buvette_commande');
            } elseif ($checker->isGranted('ROLE_ACCUEIL')){
                return $this->redirectToRoute('accueil_billetterie');
            } else {
                return $this->redirectToRoute('buvette_tarif');
            }
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/admin/setting", name="admin_setting")
     * @param Request $request
     * @return Response
     */
    public function settingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $settings = $em->getRepository(Setting::class)->find(1);

        if(!$settings){
            $settings = new Setting();
        }

        $form = $this->createForm(SettingType::class, $settings);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($settings);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Les paramètres ont bien été modifiés');
            }
            else{
                $request->getSession()->getFlashBag()->add('error', 'Les paramètres n\'ont pas pu être modifiés');
            }
        }

        return $this->render('UserBundle:Setting:setting.html.twig', array('form' => $form->createView()));
    }
}
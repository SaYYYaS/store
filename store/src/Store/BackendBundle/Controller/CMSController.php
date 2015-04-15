<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Cms;
use Store\BackendBundle\Form\CmsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CMSController
 * Module that handle CMS
 * @package Store\BackendBundle\Controller
 */
class CMSController extends Controller
{
    /**
     * View list of CMSs
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les catégories de ma base de données
        $cmss = $em->getRepository('StoreBackendBundle:Cms')->getCmsByUser(1);
        return $this->render('StoreBackendBundle:CMS:list.html.twig', ['cmss' => $cmss]);
    }

    /**
     * View a CMS
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id,$name){
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les catégories de ma base de données
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find($id);
        return $this->render('StoreBackendBundle:CMS:view.html.twig',['cms' => $cms]);
    }

    /**
     * View a cms
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find($id);
        //remove supprime l'objet en cache
        $em->remove($cms);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_cms_list');
    }

    /**
     * Create a cms
     * @param \Store\BackendBundle\Controller\Request|\Symfony\Component\HttpFoundation\Request $request
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $cms = new Cms();

        //J'associe mon jeweler à ma catégorie
        $em = $this->getDoctrine()->getManager();
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $cms->setJeweler($jeweler);

        $form = $this->createForm(new CmsType(), $cms, [
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_cms_new')
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cms);
            $em->flush();
            return $this->redirectToRoute('store_backend_cms_list');
        }
        return $this->render('StoreBackendBundle:Cms:new.html.twig',['form' => $form->createView()]);
    }
}

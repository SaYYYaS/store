<?php

namespace Store\BackendBundle\Controller;

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
}

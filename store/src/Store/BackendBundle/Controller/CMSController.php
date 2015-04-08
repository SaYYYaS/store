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
        $cmss = $em->getRepository('StoreBackendBundle:Cms')->findAll();
        dump($cmss);
        return $this->render('StoreBackendBundle:CMS:list.html.twig', ['cmss' => $cmss]);
    }

    /**
     * View a CMS
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id,$name){
        return $this->render('StoreBackendBundle:CMS:view.html.twig',['id' => $id, 'name' => $name]);
    }
}

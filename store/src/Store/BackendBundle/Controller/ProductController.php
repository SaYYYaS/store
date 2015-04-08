<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 * Module that handle product
 * @package Store\BackendBundle\Controller
 */
class ProductController extends Controller
{
    /**
     * View list of products
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        //Récupere le manager de doctrine : Le conteneur d'objets (em = entity manager)
        //Conteneur d'objet de doctrine
        $em = $this->getDoctrine()->getManager();
        //Récupère tous les produits de ma base de données
        $products = $em->getRepository('StoreBackendBundle:Product')->findAll();
        dump($products);
        return $this->render('StoreBackendBundle:Product:list.html.twig', ['products' => $products]);
    }

    /**
     * View a product
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id,$name){
        return $this->render('StoreBackendBundle:Product:view.html.twig',['id' => $id, 'name' => $name]);
    }
}

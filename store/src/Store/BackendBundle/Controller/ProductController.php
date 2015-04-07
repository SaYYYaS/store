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
        return $this->render('StoreBackendBundle:Product:list.html.twig');
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

<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SupplierController
 * Module that handle product
 * @package Store\BackendBundle\Controller
 */
class SupplierController extends Controller
{
    /**
     * View list of categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('StoreBackendBundle:Supplier:list.html.twig');
    }

    /**
     * View a Supplier
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name)
    {
        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            ['id' => $id, 'name' => $name]
        );
    }
}

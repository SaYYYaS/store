<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * Module that handle product
 * @package Store\BackendBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * View list of categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        return $this->render('StoreBackendBundle:Category:list.html.twig');
    }

    /**
     * View a category
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name)
    {
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            ['id' => $id, 'name' => $name]
        );
    }
}

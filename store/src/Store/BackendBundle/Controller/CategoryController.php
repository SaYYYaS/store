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
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les catégories de ma base de données
        $categories = $em->getRepository('StoreBackendBundle:Category')->findAll();
        dump($categories);
        return $this->render('StoreBackendBundle:Category:list.html.twig',['categories' => $categories]);
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

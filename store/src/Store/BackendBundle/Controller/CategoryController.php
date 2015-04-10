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
        $categories = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser(1);
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
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les catégories de ma base de données
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id);
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            ['category' => $category]
        );
    }

    /**
     * Delete a category
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('StoreBackendBundle:Category')->find($id);
        //remove supprime l'objet en cache
        $em->remove($category);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_category_list');
    }
}

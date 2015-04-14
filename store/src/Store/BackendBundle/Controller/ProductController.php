<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Store\BackendBundle\Form\ProductType;

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
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser(2);
        return $this->render('StoreBackendBundle:Product:list.html.twig', ['products' => $products]);
    }

    /**
     * View a product
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id,$name){
        $em = $this->getDoctrine()->getManager();
        //Récupère un produit de ma base de données
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);
        return $this->render('StoreBackendBundle:Product:view.html.twig',['product' => $product]);
    }

    /**
     * Delete a product
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);
        //remove supprime l'objet en cache
        $em->remove($product);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_product_list');
    }


    /**
     * Create new product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(){
        //Je crée un forumaire de produit
        $form = $this->createForm(new ProductType());

        return $this->render('StoreBackendBundle:Product:new.html.twig',['form' => $form->createView()]);
    }
}

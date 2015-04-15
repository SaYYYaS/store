<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

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
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser(1);
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
     * @param \Symfony\Component\HttpFoundation\Request $request Qui va récuperer les donnés html passé au serveur via methode
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request){

        //Exiplication Controller::createform(FormTypeInterface $a,mixed $data,array $options )
        //$a:       Un objet qui implémente directement ou non FormTypeInterface
        //$data:    En général l'on envoit une instance de l'entité liée au controller
        //$options: Différentes options pour la vue et autres filtres
        //Je crée un forumaire lié à l'entité product grace à 'new ProductType()' (qui est le formulaire lié à l'entité product)
        //'new Product()' associe mon formulaire avec une nouvelle instance de Entity/Product
        $product = new Product();

        //J'associe mon jeweler à mon produit
        $em = $this->getDoctrine()->getManager();
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $product->setJeweler($jeweler);

        $form = $this->createForm(new ProductType(), $product, [
            'attr' =>
            [
                'method' => 'post',
                'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                'action' => $this->generateUrl('store_backend_product_new')
            ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        dump($request);
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('store_backend_product_list');
        }
        return $this->render('StoreBackendBundle:Product:new.html.twig',['form' => $form->createView()]);
    }
}

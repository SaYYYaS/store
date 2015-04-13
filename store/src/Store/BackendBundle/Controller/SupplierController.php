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
        $em = $this->getDoctrine()->getManager();
        //Récupère tous les produits de ma base de données
        $suppliers = $em->getRepository('StoreBackendBundle:Supplier')->getSupplierByUser(1);
        return $this->render('StoreBackendBundle:Supplier:list.html.twig',['suppliers' => $suppliers]);
    }

    /**
     * View a Supplier
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name)
    {
        $em = $this->getDoctrine()->getManager();
        //Récupère tous les produits de ma base de données
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id);
        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            ['supplier' => $supplier]
        );
    }

    /**
     * Delete a supplier
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id);
        //remove supprime l'objet en cache
        $em->remove($supplier);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_supplier_list');
    }
}

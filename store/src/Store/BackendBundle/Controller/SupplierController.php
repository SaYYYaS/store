<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Supplier;
use Store\BackendBundle\Form\SupplierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function viewAction(Supplier $id, $name)
    {
        $supplier = $id;
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
    public function deleteAction(Supplier $id){
        $em = $this->getDoctrine()->getManager();
        $supplier = $id;
        //remove supprime l'objet en cache
        $em->remove($supplier);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_supplier_list');
    }

    public function newAction(Request $request){
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(),$supplier);
        if($form->isValid()){
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($supplier);
            $em->flush();

            return $this->redirectToRoute('store_backend_supplier_list');
        }
        return $this->render('StoreBackendBundle:Supplier:new.html.twig',['form' => $form->createView()]);
    }

    public function activateAction(Supplier $id, $active){

        $supplier = $id;

        $supplier->setActive($active);
        $em = $this->getDoctrine()->getManager();
        $em->persist($supplier);
        $em->flush();

        //Flash message
        $state = $active ?'activé' : 'désactivé';
        $template = $active ?'success' : 'warning';
        $this->get('session')->getFlashbag()->add($template,'Le fournisseur : ' . $supplier . ' à été ' . $state  . '.' );

        //return $this->redirectToRoute('store_backend_supplier_list');
        return new JsonResponse(['template' => $template]);
    }
}

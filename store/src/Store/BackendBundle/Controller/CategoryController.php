<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $categories = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser($this->getUser());
        return $this->render('StoreBackendBundle:Category:list.html.twig',['categories' => $categories]);
    }

    /**
     * View a category
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Category $id, $name)
    {
        //Récupère selon l'id une catégorie
        $category = $id;
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
    public function deleteAction(Category $id){
        $em = $this->getDoctrine()->getEntityManager();
        $category = $id;
        //remove supprime l'objet en cache
        $em->remove($category);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_category_list');
    }

    /**
     * Create a category
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $category = new Category();
        $user = $this->getUser();
        //J'associe mon jeweler à ma catégorie
        $category->setJeweler($user);

        $form = $this->createForm(new CategoryType(), $category, [
            'validation_groups' => 'new',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_category_new')
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('store_backend_category_list');
        }
        return $this->render('StoreBackendBundle:Category:new.html.twig',['form' => $form->createView()]);
    }

    /**
     * Create a category
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Store\BackendBundle\Entity\Category $id
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Category $id){
        $category = $id;

        $form = $this->createForm(new CategoryType(), $category, [
            'validation_groups' => 'edit',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_category_edit',['id' => $category->getId()])
                ]
        ]);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);

            if($category->getProduct()->count() == 0){
                $msg = "Attention, la catégorie '{$category->getTitle()}' ne contient aucun produits";
                $this->get('store.backend.notification')
                    ->notify($category->getId(), $msg, 'category', 'danger');
            }

            $em->flush();
            return $this->redirectToRoute('store_backend_category_list');
        }
        return $this->render('StoreBackendBundle:Category:edit.html.twig',['form' => $form->createView()]);
    }

    /**
     * To activate a category
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Category $id
     * @param $active
     * @return JsonResponse
     */
    public function activateAction(Request $request,Category $id, $active){

        $category = $id;

        $category->setActive($active);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        //Flash message
        $state = $active ?'activée' : 'désactivée';
        $template = $active ?'success' : 'warning';
        $this->get('session')->getFlashbag()->add($template,'La catégorie : "' . $category . '" à été ' . $state  . '.' );

        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['template' => $template]);
        }

        return $this->redirectToRoute('store_backend_category_list');

    }
}

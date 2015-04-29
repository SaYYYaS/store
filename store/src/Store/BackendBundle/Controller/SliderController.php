<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Slider;
use Store\BackendBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SliderController
 * Module that handle Slider
 * @package Store\BackendBundle\Controller
 */
class SliderController extends Controller
{
    /**
     * View list of Sliders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les pages slider de ma base de données
        $sliders = $em->getRepository('StoreBackendBundle:Slider')->getSlidersByUser($this->getUser());

        //Je récupère le bundle paginator
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $sliders,
            $request->query->get('page', 1)/*page number in url arg */,
            5/*limit product per page*/
        );

        return $this->render('StoreBackendBundle:Slider:list.html.twig', ['sliders' => $pagination]);
    }

    /**
     * View a Slider
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Slider $id){
        $slider = $id;
        return $this->render('StoreBackendBundle:Slider:view.html.twig',['slider' => $slider]);
    }

    /**
     * View a Slider
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Slider $id){
        $em = $this->getDoctrine()->getManager();
        $slider = $id;
        //remove supprime l'objet en cache
        $em->remove($slider);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_slider_list');
    }

    /**
     * Create a Slider
     * @param \Store\BackendBundle\Controller\Request|\Symfony\Component\HttpFoundation\Request $request
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $slider = new Slider();

        $form = $this->createForm(new SliderType($this->getUser()), $slider, [
            'validation_groups' => 'new',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_slider_new')
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $slider->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();
            return $this->redirectToRoute('store_backend_slider_list');
        }
        return $this->render('StoreBackendBundle:Slider:new.html.twig',['form' => $form->createView()]);
    }

    /**
     * Edit a slider
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param null|\Store\BackendBundle\Entity\Slider $id (utilisation paramConverter pour convertir in en Slider et implicitement find)
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request,Slider $id = null){

        $slider = $id;
        $form = $this->createForm(new SliderType($this->getUser()), $slider, [
            'validation_groups' => 'edit',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_slider_edit',['id' => $slider->getId()])
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $slider->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();
            return $this->redirectToRoute('store_backend_slider_list');
        }
        return $this->render('StoreBackendBundle:Slider:edit.html.twig',['form' => $form->createView()]);
    }

    /**
     * Activate Slider page
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Slider $id
     * @param $active
     * @return JsonResponse
     */
    public function activateAction(Request $request, Slider $id, $active){

        $slider = $id;

        $slider->setActive($active);
        $em = $this->getDoctrine()->getManager();
        $em->persist($slider);
        $em->flush();

        //Flash message
        $state = $active ?'activée' : 'désactivé';
        $template = $active ?'success' : 'warning';
        $this->get('session')->getFlashbag()->add($template,'Le slide lié au produit "' . $slider->getProduct() . '" à été ' . $state  . '.' );

        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['template' => $template]);
        }
        return $this->redirectToRoute('store_backend_slider_list');
    }
}

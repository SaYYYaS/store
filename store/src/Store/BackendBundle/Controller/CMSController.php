<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Cms;
use Store\BackendBundle\Form\CmsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CMSController
 * Module that handle CMS
 * @package Store\BackendBundle\Controller
 */
class CMSController extends Controller
{
    /**
     * View list of CMSs
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        //Récupère toutes les pages cms de ma base de données
        $cmss = $em->getRepository('StoreBackendBundle:Cms')->getCmsByUser($this->getUser());
        return $this->render('StoreBackendBundle:CMS:list.html.twig', ['cmss' => $cmss]);
    }

    /**
     * View a CMS
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Cms $id,$name){
        $cms = $id;
        return $this->render('StoreBackendBundle:CMS:view.html.twig',['cms' => $cms]);
    }

    /**
     * View a cms
     * @param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Cms $id){
        $em = $this->getDoctrine()->getManager();
        $cms = $id;
        //remove supprime l'objet en cache
        $em->remove($cms);
        //Flush permet d'envoyer la requette en bdd pour faire persister la modification
        $em->flush();
        return $this->redirectToRoute('store_backend_cms_list');
    }

    /**
     * Create a cms
     * @param \Store\BackendBundle\Controller\Request|\Symfony\Component\HttpFoundation\Request $request
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $cms = new Cms();
        $user = $this->getUser();

        //J'associe mon jeweler à ma page cms
        $cms->setJeweler($user);

        $form = $this->createForm(new CmsType($user), $cms, [
            'validation_groups' => 'new',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_cms_new')
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cms);
            $em->flush();
            return $this->redirectToRoute('store_backend_cms_list');
        }
        return $this->render('StoreBackendBundle:CMS:new.html.twig',['form' => $form->createView()]);
    }

    /**
     * Edit a cms
     * @param \Store\BackendBundle\Controller\Request|\Symfony\Component\HttpFoundation\Request $request
     * @param \Store\BackendBundle\Entity\Cms $id
     * @internal param $id
     * @internal param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request,Cms $id){
        $cms = $id;

        $form = $this->createForm(new CmsType(), $cms, [
            'validation_groups' => 'edit',
            'attr' =>
                [
                    'method' => 'post',
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_cms_edit',['id' => $cms->getId()])
                ]
        ]);

        //Envoie les donnés de la $request au formulaire, de tel sorte que le formulaire ai accès aux données
        $form->handleRequest($request);

        //Si la totalité de formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cms);
            $em->flush();
            return $this->redirectToRoute('store_backend_cms_list');
        }
        return $this->render('StoreBackendBundle:CMS:edit.html.twig',['form' => $form->createView()]);
    }

    /**
     * Activate cms page
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Cms $id
     * @param $active
     * @return JsonResponse
     */
    public function activateAction(Request $request, Cms $id, $active){

        $cms = $id;

        $cms->setActive($active);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cms);
        $em->flush();

        //Flash message & getting translator
        $l18n = $this->get('translator');
        $state = $active ?'activated' : 'disabled';
        $state = $l18n->trans($state);
        $template = $active ?'success' : 'warning';
        $this->get('session')->getFlashbag()->add($template,
           $l18n->trans('cms.flashdata.state',['%state%' => $state, '%page%' => $cms->getTitle()], 'cms')
        );


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['template' => $template]);
        }
        return $this->redirectToRoute('store_backend_cms_list');

    }

    /**
     * Change cms page state
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Cms $id
     * @param $state
     * @internal param $state (lu, en cours, non lu)
     * @return JsonResponse
     */
    public function stateAction(Request $request, Cms $id, $state){

        $cms = $id;

        $cms->setState($state);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cms);
        $em->flush();

        //Flash message

        switch($state){
            case 0 :
                $state    = 'non lu';
                $template = 'danger';
                break;
            case 1 :
                $state = 'en cours de lecture';
                $template = 'info';
                break;
            case 2 :
                $state = 'lu';
                $template = 'success';
                break;
        }
        $this->get('session')->getFlashbag()->add($template,'La page : "' . $cms . '" à été ' . $state  . '.' );

        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(['template' => $template]);
        }
        return $this->redirectToRoute('store_backend_cms_list');

    }
}

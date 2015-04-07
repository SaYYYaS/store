<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class StaticsController
 * @package Store\BackendBundle\Controller
 */
class StaticsController extends Controller
{
    /**
     * Page contact
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        #Je retourne la vue contact contenue dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:contact.html.twig');
    }

    /**
     * Page about us
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction(){
        return $this->render('StoreBackendBundle:Statics:about.html.twig');
    }

    /**
     * Page concept
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function conceptAction(){
        return $this->render('StoreBackendBundle:Statics:concept.html.twig');
    }

    /**
     * Page mentions légales
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsAction(){
        return $this->render('StoreBackendBundle:Statics:terms.html.twig');
    }
}

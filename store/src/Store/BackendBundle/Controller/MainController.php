<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package Store\BackendBundle\Controller
 */
class MainController extends Controller
{
    /**
     * Page DashBoard on backend
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('StoreBackendBundle:Main:index.html.twig');
    }
}

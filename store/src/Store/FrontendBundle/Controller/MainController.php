<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 30/04/15
 * Time: 14:54
 */

namespace Store\FrontendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {

    public function indexAction(){
       return $this->render('StoreFrontendBundle:Main:index.html.twig');
    }
} 
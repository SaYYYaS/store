<?php


namespace Store\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    public function loginAction(Request $request){
        return $this->render('StoreBackendBundle:Security:login.html.twig');
    }
} 
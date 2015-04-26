<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 26/04/2015
 * Time: 12:17
 */

namespace Store\BackendBundle\Controller;


use Store\BackendBundle\Entity\Jeweler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JewelerController extends Controller {

    public function profilAction(Jeweler $id){

        return $this->render('StoreBackendBundle:Jeweler:profil.html.twig');
    }
}
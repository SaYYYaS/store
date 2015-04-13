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
        //stats bloc
        $em = $this->getDoctrine()->getManager();
        $nbrprods = $em->getRepository('StoreBackendBundle:Product')->getCountByUser(1);
        $nbrcats = $em->getRepository('StoreBackendBundle:Category')->getCountByUser(1);
        $nbrsuppliers = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser(1);
        $nbrorders = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser(1);
        $nbrcoms = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser(1);
        $nbrpages = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser(1);


        //meta-informations
        $coms = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser(1,5);
        $totalmoney = $em->getRepository('StoreBackendBundle:Orders')->getSumOrdersByUser(1);
        $orders = $em->getRepository('StoreBackendBundle:Orders')->getOrdersByUser(1,10);

        return $this->render('StoreBackendBundle:Main:index.html.twig',
            [
                'nbrprods'     => $nbrprods,
                'nbrcats'      => $nbrcats,
                'nbrcoms'      => $nbrcoms,
                'nbrorders'    => $nbrorders,
                'nbrpages'     => $nbrpages,
                'nbrsuppliers' => $nbrsuppliers,
                'coms'         => $coms,
                'orders'       => $orders,
                'totalmoney'   => $totalmoney
            ]
        );
    }
}

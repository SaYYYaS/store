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
        $em             = $this->getDoctrine()->getManager();
        $nbrprods       = $em->getRepository('StoreBackendBundle:Product')->getCountByUser(1);
        $likes          = $em->getRepository('StoreBackendBundle:Product')->getLikesByUser(1);
        $nbrcats        = $em->getRepository('StoreBackendBundle:Category')->getCountByUser(1);
        $nbrsuppliers   = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser(1);
        $nbrorders      = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser(1);
        $nbrcoms        = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser(1);
        $nbrpages       = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser(1);


        //meta-informations
        $qteprods       = $em->getRepository('StoreBackendBundle:Product')->getQuantitiesByUser(1,2);
        $coms           = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser(1,5);
        $coms_pending   = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser(1,null, $state = 0);
        $coms_active    = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser(1,null, $state = 1);
        $coms_inactive  = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser(1,null, $state = 2);
        $totalmoney     = $em->getRepository('StoreBackendBundle:Orders')->getSumOrdersByUser(1);
        $orders         = $em->getRepository('StoreBackendBundle:Orders')->getOrdersByUser(1,10);
        $msgs           = $em->getRepository('StoreBackendBundle:Message')->getMessagesByUser(1,10);
        $categories     = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser(1);
        $business       = $em->getRepository('StoreBackendBundle:Business')->getBusinessByUser(1,10);
        $jeweler        = $em->getRepository('StoreBackendBundle:Jeweler')->getJewelerByUser(1);
        dump($orders);

        return $this->render('StoreBackendBundle:Main:index.html.twig',
            [
                'nbrprods'      => $nbrprods,
                'qteprods'      => $qteprods,
                'jeweler'       => $jeweler,
                'nbrcats'       => $nbrcats,
                'nbrcoms'       => $nbrcoms,
                'nbrorders'     => $nbrorders,
                'nbrpages'      => $nbrpages,
                'nbrsuppliers'  => $nbrsuppliers,
                'coms'          => $coms,
                'business'      => $business,
                'coms_active'   => $coms_active,
                'coms_inactive' => $coms_inactive,
                'coms_pending'  => $coms_pending,
                'orders'        => $orders,
                'msgs'          => $msgs,
                'likes'         => $likes,
                'categories'    => $categories,
                'totalmoney'    => $totalmoney
            ]
        );
    }
}

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
        $user = $this->getUser();
        $em             = $this->getDoctrine()->getManager();
        $nbrprods       = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $likes          = $em->getRepository('StoreBackendBundle:Product')->getLikesByUser($user);
        $nbrcats        = $em->getRepository('StoreBackendBundle:Category')->getCountByUser($user);
        $nbrsuppliers   = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);
        $nbrorders      = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser($user);
        $nbrcoms        = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);
        $nbrpages       = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser($user);


        //meta-informations
        $qteprods       = $em->getRepository('StoreBackendBundle:Product')->getQuantitiesByUser($user,2);
        $coms           = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser($user,5);
        $coms_pending   = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser($user,null, $state = 0);
        $coms_active    = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser($user,null, $state = 1);
        $coms_inactive  = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser($user,null, $state = 2);
        $totalmoney     = $em->getRepository('StoreBackendBundle:Orders')->getSumOrdersByUser($user);
        $orders         = $em->getRepository('StoreBackendBundle:Orders')->getOrdersByUser($user,10);
        $msgs           = $em->getRepository('StoreBackendBundle:Message')->getMessagesByUser($user,10);
        $categories     = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser($user);
        $business       = $em->getRepository('StoreBackendBundle:Business')->getBusinessByUser($user,10);
        $jeweler        = $em->getRepository('StoreBackendBundle:Jeweler')->getJewelerByUser($user);
        $last_sales     = $em->getRepository('StoreBackendBundle:Orders')->getLastSalesByUser($user, new \DateTime('now - 6 month'));
        dump($last_sales);

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

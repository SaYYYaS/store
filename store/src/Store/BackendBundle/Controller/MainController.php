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
//        $mail = $this->get('store.backendbundle.email');
//        $mail->send();


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
        $last_sales     = $em->getRepository('StoreBackendBundle:Orders')->getStatsLastSalesByUser($user, new \DateTime('now - 6 month'));

        //ratio products in cms
        $prods_per_cms  = $em->getRepository('StoreBackendBundle:Cms')->getProductCmsCompletion($user);
        $prods_per_cms  = round(($prods_per_cms['products_in_cms'] / $prods_per_cms['all_products']) *100,1);
        //ratio products by details
        $prods_compl_details  = $em->getRepository('StoreBackendBundle:Product')->getProductCompletionDetails($user);
        $prods_compl_details  = round(($prods_compl_details / $nbrprods)*100,1);
        //ratio products by meta
        $prods_compl_metas  = $em->getRepository('StoreBackendBundle:ProductMeta')->getProductCompletionMetas($user);
        $prods_compl_metas  = round(($prods_compl_metas / $nbrprods ) * 100,1) ;

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
                'totalmoney'    => $totalmoney,
                'last_sales'    => $last_sales,
                'prods_per_cms' => $prods_per_cms,
                'prods_compl_details' => $prods_compl_details,
                'prods_compl_metas'     => $prods_compl_metas
            ]
        );
    }
}

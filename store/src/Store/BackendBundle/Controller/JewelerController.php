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

    public function profileAction(Jeweler $id){

        $jeweler = $id;

        $em             = $this->getDoctrine()->getManager();
        //stats and counts
        $nbrprods       = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($jeweler);
        $likes          = $em->getRepository('StoreBackendBundle:Product')->getLikesByUser($jeweler);
        $nbrcats        = $em->getRepository('StoreBackendBundle:Category')->getCountByUser($jeweler);
        $nbrsuppliers   = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($jeweler);
        $nbrorders      = $em->getRepository('StoreBackendBundle:Orders')->getCountByUser($jeweler);
        $nbrcoms        = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($jeweler);
        $nbrpages       = $em->getRepository('StoreBackendBundle:Cms')->getCountByUser($jeweler);
        $nbrmsgs        = $em->getRepository('StoreBackendBundle:Message')->getCountByUser($jeweler);


        //jeweler's related infos in tab
        $coms           = $em->getRepository('StoreBackendBundle:Comment')->getCommentsByUser($jeweler);
        $orders         = $em->getRepository('StoreBackendBundle:Orders')->getOrdersByUser($jeweler, null);
        $msgs           = $em->getRepository('StoreBackendBundle:Message')->getMessagesByUser($jeweler);
        $jeweler_meta   = $em->getRepository('StoreBackendBundle:JewelerMeta')->getMetasByUser($jeweler);

        $tags           = $em->getRepository('StoreBackendBundle:Tag')->getTagsByUser($jeweler);

        return $this->render('StoreBackendBundle:Jeweler:profile.html.twig',[
            'jeweler'        => $jeweler,
            'nbrprods'       => $nbrprods,
            'nbrcats'        => $nbrcats,
            'nbrcoms'        => $nbrcoms,
            'nbrpages'       => $nbrpages,
            'nbrorders'      => $nbrorders,
            'nbrsuppliers'   => $nbrsuppliers,
            'nbrmsgs'        => $nbrmsgs,
            'likes'          => $likes,
            'jeweler_meta'   => $jeweler_meta,
            'tags'           => $tags,
            'coms'           => $coms,
            'orders'         => $orders,
            'msgs'            => $msgs
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 28/04/15
 * Time: 10:40
 */

namespace Store\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller{

    public function getMessagesAction(){
        $user = $this->getUser();
        $msgs = $this->getDoctrine()
            ->getManager()
            ->getRepository('StoreBackendBundle:Message')
            ->getMessagesByUser($user,15)
        ;
        return $this->render('StoreBackendBundle:Partial:messages.html.twig', ['msgs' => $msgs ]);
    }

    public function getOrdersAction(){
        $user = $this->getUser();
        $orders = $this->getDoctrine()
            ->getManager()
            ->getRepository('StoreBackendBundle:Orders')
            ->getOrdersByUser($user,15)
        ;
        return $this->render('StoreBackendBundle:Partial:orders.html.twig', ['orders' => $orders ]);
    }
} 
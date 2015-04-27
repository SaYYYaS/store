<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 10:48
 */

namespace Store\BackendBundle\Listener;

use Doctrine\ORM\EntityManager;
use Store\BackendBundle\Notification\Notification;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


class AuthListener
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $securityContext;
    /**
     * @var \Store\BackendBundle\Notification\Notification
     */
    private $notif;

    public function __construct(EntityManager $em, SecurityContextInterface $securityContext, Notification $notif){
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->notif = $notif;
    }

    /**
     * Methode qui est déclanchée après l'évènement InteractiveLogin
     *  qui est l'action de login dans la securité
     * @param InteractiveLoginEvent $event
     */
    public function onAuthSuccess(InteractiveLoginEvent  $event)
    {
        $now = new \DateTime('now');
        $user = $this->securityContext->getToken()->getUser();
        $user->setDateAuth($now);
        $this->em->persist($user);
        $this->em->flush();

        $this->recoverProductNotifs($user);

    }


    /**
     * Permet de reload les notif à la connection
     * TODO: refactor pour passer par des objets
     * @param $user
     */
    private function recoverProductNotifs($user){
        $products =  $this->em->getRepository('StoreBackendBundle:Product')->getQuantitiesByUser($user, 5);
        //Test
        foreach($products as $product){
            if($product['quantity'] == 1){

                $this->notif->notify($product['id'],'Le produit "' . $product['title'] . '" est unique!','product', 'danger');
            }
            else{
                $this->notif->notify($product['id'],'Le produit "' . $product['title'] . '" est bientôt épuisé ','product', 'warning');
            }
        }

    }
}
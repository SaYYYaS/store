<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 10:48
 */

namespace Store\BackendBundle\Listener;

use Doctrine\ORM\EntityManager;
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

    public function __construct(EntityManager $em, SecurityContextInterface $securityContext){
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    /**
     * Methode qui est déclanchée après l'évènement InteractiveLogin
     *  qui est l'action de login dans la securité
     * @param InteractiveLoginEvent $event
     */
    public function onAuthSuccess(GetResponseEvent  $event)
    {
        $now = new \DateTime('now');
        $user = $this->securityContext->getToken()->getUser();
        $user->setDateAuth($now);
        $this->em->persist($user);
        $this->em->flush();

    }
}
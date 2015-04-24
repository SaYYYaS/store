<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 17:11
 */


namespace Store\BackendBundle\Notification;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Service de notification
 * Class Notification
 * @package Store\BackendBundle\Notification
 */
class Notification {
    /**
     * @var Session
     */
    protected $session;

    /**
     * Constructeur qui recevra
     */
    function __construct(Session $session)
    {

        $this->session = $session;
    }

    /**
     * Notification d'une action
     * @param $msg
     * @param string $priority
     */
    public function notify($msg, $priority = 'alert'){

        $this->session->set('alert', ['message' =>$msg, 'priority' => $priority]);
    }
}
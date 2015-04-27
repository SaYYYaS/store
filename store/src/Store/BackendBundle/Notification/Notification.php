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
     * @param $id : id de mon objet
     * @param $msg : le msg à afficher
     * @param $nature : product | cs | category
     * @param string $priority | concerne la pirorité du message
     */
    public function notify($id, $msg, $nature, $priority = 'alert'){

        // Nous récupérons le tableau de notifications par sa nature
                                         // $nature => session key, [] => !isset(key) new []
        $tabsession = $this->session->get($nature,[]);

        // Nous stockons dans ce tableau la notif
        // avec un message, une priorité et une date
        $tabsession[$id] = [
            'message' => $msg,
            'priority' => $priority,
            'date' => new \DateTime('now')
        ];

        // Enfin nous enregistrons le tableau des notification en session
        $this->session->set($nature, $tabsession);
    }

    public function getSession(){
        return $this->session;
    }
}
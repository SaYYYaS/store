<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 14:33
 */

namespace Store\BackendBundle\Email;


class Email {
    /**
     * @var \Twig_TemplateTemplate
     */
    private $twig;
    /**
     * @var \SwitftMailer
     */
    private $mailer;

    /**
     * Constructeur de ma classe Email
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     */
    function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }


    /**
     * Fonction qui envoi un email à un utilisateur
     */
    public function send(){
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('testing@test.com')
            ->setTo('said@n-sens.com')
            ->setBody($this->twig->display('StoreBackendBundle:Email:email.html.twig'));

        $this->mailer->send($message);
    }
} 
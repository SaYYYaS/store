<?php


namespace Store\BackendBundle\Controller;


use Store\BackendBundle\Entity\Jeweler;
use Store\BackendBundle\Form\JewelerRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{

    public function loginAction(Request $request){

        /**
         * On intérroge le mécanisme de sécurité de Symfony 2 en session
         */
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        //je retourne la vue login de mon dossier Security
        return $this->render('StoreBackendBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * Action d'enregistrement d'un nouvel utilisateur
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(){
        $factory = $this->get('security.encoder_factory');
        //$user = new \Entity\Jeweler();

//        $encoder = $factory->getEncoder($user);
//        $password = $encoder->encodePassword('ryanpass', $user->getSalt());
//        $user->setPassword($password);
        $form = $this->createForm(new JewelerRegisterType());
        return $this->render('StoreBackendBundle:Security:register.html.twig',['form' => $form->createView()]);
    }
} 
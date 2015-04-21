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
    public function registerAction(Request $request){

        $form = $this->createForm(new JewelerRegisterType());
        $em = $this->getDoctrine()->getEntityManager();
        $user = new Jeweler;
        $form = $this->createForm(new JewelerRegisterType(), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $factory = $this->get('security.encoder_factory');
            $group = $this->getDoctrine()->getEntityManager()->getRepository('StoreBackendBundle:Groups')->find(1);
            $user->addGroup($group);
            $encoder = $factory->getEncoder($user);
            $user->setSalt(uniqid(mt_rand(), true));
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('store_backend_security_login');
        }

        return $this->render('StoreBackendBundle:Security:register.html.twig',['form' => $form->createView()]);
    }

} 
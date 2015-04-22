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
     * Le new Jeweler n'est pas hydraté par le formulaire, tout ses champs sont à nul
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request){

        //creation du formulaire via le type
        $form = $this->createForm(new JewelerRegisterType());
        $em = $this->getDoctrine()->getEntityManager();
        $user = new Jeweler();
        $form = $this->createForm(new JewelerRegisterType(), $user, [
            'validation_groups' => 'register',
            'attr' =>
                [
                    'method' => 'post',
                    //Permet de définir un scope de validation
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('store_backend_security_register')
                ]
        ]);

        //Hydratation du formulaire
        $form->handleRequest($request);

        //Test la validité des datas envoyés
        if ($form->isValid()) {

            //Recupération du factory encoder
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            //J'encode le mdp avec le salt en utilisant le factory
            $password = $form['password']->getData();
            $password = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($password);

            //Récupération du groupe et ajout du group au nouvel utilisateur
            $group = $this->getDoctrine()->getEntityManager()->getRepository('StoreBackendBundle:Groups')->find(1);
            $user->addGroup($group);

            //Persist and flush
            $em->persist($user);
            $em->flush();
            //J'envoie un message flash de confirmation
            $this->get('session')->getFlashbag()->add('success','Votre compte à bien été enregistré. ');
            $this->get('session')->getFlashbag()->add('info','Vous devez valider votre compte par email');

            //Je redirige l'utilisateur vers la page de login
            return $this->redirectToRoute('store_backend_security_login');
        }

        //Retourne la vue de register
        return $this->render('StoreBackendBundle:Security:register.html.twig',['form' => $form->createView()]);
    }

} 
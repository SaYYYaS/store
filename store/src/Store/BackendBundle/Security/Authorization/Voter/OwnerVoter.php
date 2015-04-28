<?php

namespace Store\BackendBundle\Security\Authorization\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class OwnerVoter implements VoterInterface {

    /**
     * LE PLUS IMPORTANT
     * Mécanisme que l'on implémente pour voter les droits et
     * permissions de l'utilisateur
     * @param TokenInterface $token
     * @param null|object $object
     * @param array $attributes
     * @return int|void
     */
    public function vote(TokenInterface $token, $object, array $attributes){

        /**
         * VoterInterface::ACCESS_GRANTED : Acces permis (200)
         * VoterInterface::ACCESS_DENIED  : Access interdit (403)
         * VoterInterface::ACCESS_ABSTAIN : Ignorer
         */

        //Récupere l'utilisateur en session
        $user = $token->getUser();

        //Test si l'user en session est bien du type UserInterface
        //(ce qui est le cas : Jeweler implémente bien AdvancedUserInterface)
        //Test aussi si l'objet recu contient bien la méthode getJeweler
        if($user instanceof UserInterface && method_exists($object,'getJeweler')) {
            if($object->getJeweler()->getId() == $user->getId()){
                return VoterInterface::ACCESS_GRANTED;
            }

        }

        return VoterInterface::ACCESS_DENIED;


    }

    /**
     * Checks if the voter supports the given attribute.
     * Cette méthode me permet de rérupérer l'/les attribut(s) envoyé(s)
     * @param string $attribute An attribute
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Checks if the voter supports the given class.
     * Me permet de faire des restrictions sur l'utilisation de ce Voter
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        return true;
    }


}
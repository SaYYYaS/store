<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class JewelerRegisterType
 * Formulaire de création de produits
 * @package Store\BackendBundle\Form
 */
class JewelerRegisterType extends AbstractType{

    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité Jeweler

        $builder->add('title',null,
            [
                'label'     => 'Nom de la bijouterie',
                'required'  => true,
                'attr'      =>
                    [
                        'class'         => 'form-control',
                        'placeholder'   => 'Nom ou marque',
                        'pattern'       => "[\\w\\d\\-\\s]{5,}"
                    ]
            ]);

        $builder->add('username',null,
        [
            'label'     => 'Nom d\'utilisateur',
            'required'  => true,
            'attr'      =>
            [
                'class'         => 'form-control',
                'placeholder'   => 'Nom d\'utilisateur',
                'pattern'       => "[\\w\\d\\-]{5,}"
            ]
        ]);

        $builder->add('email','email',
            [
                'label'     => 'Email',
                'required'  => true,
                'attr'      =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'user@domain.net',
                    ]
            ]);

        $builder->add('password','repeated',
            [
                'label'             => 'Email',
                'required'          => true,
                'type'              => 'password',
                'invalid_message'   => 'Les mots de passe doivent correspondre',
                'options'           => ['required' => true],
                'first_name'        => 'mdp',
                'second_name'       => 'mdp_conf',
                'error_bubbling'    => false,
                'first_options'     =>
                    [
                        'label' => 'Mot de passe',
                        'attr'  =>
                            [
                                'class'          => 'form-control',
                                'placeholder'  => ' Au moins 6 charactères',
                                'pattern'      => '.{6,}',
                                'autocomplete' => 'off'
                            ]
                    ]
                ,
                'second_options' =>
                    [
                        'label' => 'Mot de passe(confirmer)',
                        'attr'  =>
                            [
                                'class'          => 'form-control',
                                'placeholder'  => 'Ressaisir mot de passe',
                                'pattern'      => '.{6,}',
                                'autocomplete' => 'off'
                            ]
                    ]
                ,
                'attr' =>
                    [
                        'autocomplete'   => 'off'
                    ]
            ]);


        $builder->add('envoyer','submit',
            [
                'attr' =>
                    [
                        'class' => 'pull-right btn btn-primary',
                    ]
            ]);

    }

    /**
    * Methode qui lie mon formulaire à l'entité Jeweler
    * Car mon formulaire enregistre un jeweler dans la table Jeweler
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Jeweler']);
    }

    /**
     * Methode deprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Jeweler']);
    }

    /**
    * Retourne le nom du formulaire selon la structure ns_bundle_controller
    * Returns the name of this type.
    *
    * @return string The name of this type
    */
    public function getName()
    {
        return "store_backend_jeweler_register";
    }

}
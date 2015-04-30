<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 29/04/15
 * Time: 11:25
 */

namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InformationsType extends AbstractType{

    /**
     * Methode qui va construire le formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité cms
        $builder->add('city',null,
            [
                'label' => 'Ville',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Votre ville',
                    ]
            ]);

        $builder->add('address',null,
            [
                'label' => 'Addresse',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Votre addresse',
                    ]
            ]);
        $builder->add('phone',null,
            [
                'label' => 'N° de telephone',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => '0612345678',
                    ]
            ]);

        $builder->add('propos',null,
            [
                'label' => 'A propos',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Informations de base',
                    ]
            ]);

        $builder->add('website',null,
            [
                'label' => 'Site web',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'http://www.monsite.com',
                    ]
            ]);


        $builder->add('dawanda',null,
            [
                'label' => 'Danwanda',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'votre dawanda',
                    ]
            ]);


        $builder->add('littlemarket',null,
            [
                'label' => 'LittleMarket',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'votre littlemarket',
                    ]
            ]);


        $builder->add('retour',null,
            [
                'label' => 'Retours',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Vos conditions de retour',
                    ]
            ]);


        $builder->add('delai',null,
            [
                'label' => 'Délais',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'En heure (h.)',
                    ]
            ]);

        $builder->add('expedition',null,
            [
                'label' => 'Expédition de colis',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Processus de transport de colis',
                    ]
            ]);

        $builder->add('mention',null,
            [
                'label' => 'Mentions légales',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Siège social et status, CDV et CGV',
                    ]
            ]);

        $builder->add('Jeweler', new JewelerType());

        $builder->add('envoyer','submit',
            [
                'label' => 'Enregistrer mes informations',
                'attr' =>
                    [
                        'class' => 'pull-right btn btn-primary',
                    ]
            ]);

        $builder->add('optin','checkbox',
            [
                'label' => 'Accepter la newsletter',
                'attr' =>
                    [
                        'class' => 'checkbox',

                    ]
            ]);

    }

    /**
     * Methode qui lie mon formulaire à l'entité cms
     * Car mon formulaire enregistre un cms dans la table cms
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver){
    }

    /**
     * Methode deprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\JewelerMeta']);
    }

    /**
     * Retourne le nom du formulaire selon la structure ns_bundle_controller
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "store_backend_informations";
    }
}
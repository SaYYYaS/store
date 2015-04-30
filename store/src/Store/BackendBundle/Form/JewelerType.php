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

class JewelerType extends AbstractType{

    /**
     * Methode qui va construire le formulaire
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder->add('description',null,
            [
                'label'     => 'Description de la bijouterie',
                'required'  => true,
                'attr'      =>
                    [
                        'class'         => 'form-control',
                        'placeholder'   => 'Des informations cools'
                    ]
            ]);

        $builder->add('title',null,[
           'label' => 'Titre de la boutique',
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Titre de la boutique'
            ]
        ]);

        $builder->add('email','email',[
            'label' => 'Votre Email',
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Titre de la boutique'
            ]
        ]);

        $builder->add('file','file',
            [
                'label' => 'Image de présentation',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'accept' => 'image/*',
                        'capture' => 'capture'
                    ]
            ]);

        $builder->add('type','choice',
            [
                'label' => 'Type de structure',
                'choices' => ['0' => 'Aucun', '1' => 'SARL', '2' => 'SA'], //Les choix disponibles
                'preferred_choices' => ['0'], //Le choix par défaut
                'required' => true, //liste déroulante
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);
    }

    public function getName(){
        return "store_backend_jeweler";
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

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Jeweler']);
    }

}
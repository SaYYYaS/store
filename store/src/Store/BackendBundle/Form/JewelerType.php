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
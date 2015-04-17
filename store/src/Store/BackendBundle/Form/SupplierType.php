<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class categoryType
 * Formulaire de création de produits
 * @package Store\BackendBundle\Form
 */
class SupplierType extends AbstractType{

    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité supplier
        $builder->add('name',null,
        [
            'label' => 'Nom du fournisseur',
            'attr' =>
            [
                'class' => 'form-control',
                'placeholder' => 'Mettre un nom de fournisseur',
            ]
        ]);

        $builder->add('active',null,
            [
                'label' => 'Activer ?',
                'required' => true, //liste déroulante
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);

        $builder->add('description',null,
            [
                'label' => 'Description',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Description du fournisseur',
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
    * Methode qui lie mon formulaire à l'entité supplier
    * Car mon formulaire enregistre un produit dans la table supplier
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver){
    }

    /**
     * Methode deprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Supplier']);
    }

    /**
    * Retourne le nom du formulaire selon la structure ns_bundle_controller
    * Returns the name of this type.
    *
    * @return string The name of this type
    */
    public function getName()
    {
        return "store_backend_supplier";
    }

}
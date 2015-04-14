<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ProductType
 * Formulaire de création de produits
 * @package Store\BackendBundle\Form
 */
class ProductType extends AbstractType{

    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité Product
        $builder->add('title',null,
        [
            'label' => 'Nom du bijoux',
            'attr' =>
            [
                'class' => 'form-control',
                'placeholder' => 'Mettre un titre soigné',
            ]
        ]);

        $builder->add('ref',null,
            [
                'label' => 'Référence produit',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'AAAA-XX-B',
                        'patern' => '/\[A-Z]{4}-[0-9]{2}-[A-Z]{1}/' //Pourra être remplacé directement dans l'entité lors de la validation
                    ]
            ]);

        $builder->add('category',null,
            [
                'label' => 'Catégorie(s) associée(s)',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Mettre un titre soigné',
                    ]
            ]);

        $builder->add('summary',null,
            [
                'label' => 'Courte description',
                'attr' =>
                    [
                        'div' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Description courte',
                    ]
            ]);

        $builder->add('description',null,
            [
                'label' => 'Description',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Description du bijoux',
                    ]
            ]);

        $builder->add('price',null,
            [
                'label' => 'Prix',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Valeur en €',
                    ]
            ]);

        $builder->add('taxe','choice',
            [
                'label' => 'Taxe',
                'choices' => ['5' => '5', '19.6' => '19.6', '20' => '20'], //Les choix disponibles
                'preferred_choices' => ['20'], //Le choix par défaut
                'required' => true, //liste déroulante
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);

        $builder->add('quantity',null,
            [
                'label' => 'Quantité du produit',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Renseignez la quantité',
                    ]
            ]);

        $builder->add('active',null,
            [
                'label' => 'Produit en ligne?',
                'attr' =>
                    [
                        'class' => 'checkbox',
                    ]
            ]);

        $builder->add('cover',null,
            [
                'label' => 'Image à la une?',
                'attr' =>
                    [
                        'class' => 'checkbox',
                    ]
            ]);

        $builder->add('cms',null,
            [
                'label' => 'Associer aux pages suivante',
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);

        $builder->add('supplier',null,
            [
                'label' => 'Fournisseurs',
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);

        $builder->add('tag',null,
            [
                'label' => 'Liste des tags',
                'attr' =>
                    [
                        'class' => 'form-control',
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
    * Methode qui lie mon formulaire à l'entité product
    * Car mon formulaire enregistre un produit dans la table product
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver){
    }

    /**
     * Methode deprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Product']);
    }

    /**
    * Retourne le nom du formulaire selon la structure ns_bundle_controller
    * Returns the name of this type.
    *
    * @return string The name of this type
    */
    public function getName()
    {
        return "store_backend_product";
    }

}
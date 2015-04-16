<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class categoryType
 * Formulaire de création de cms
 * @package Store\BackendBundle\Form
 */
class CmsType extends AbstractType{

    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité cms
        $builder->add('title',null,
        [
            'label' => 'Nom de la page',
            'attr' =>
            [
                'class' => 'form-control',
                'placeholder' => 'Mettre un nom de page',
            ]
        ]);

        $builder->add('dateActive','date',
            [
                'label' => 'Date d\'activation',
                'input'  => 'datetime',
                'widget' => 'choice'
            ]);

        $builder->add('summary',null,
            [
                'label' => 'Résumé',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Résumé de la catégorie',
                    ]
            ]);

        $builder->add('description',null,
            [
                'label' => 'Description',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Description de la catégorie',
                    ]
            ]);

        $builder->add('image','url',
            [
                'label' => 'Image',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'http://image.com/image.jpg',
                    ]
            ]);

        $builder->add('video',null,
            [
                'label' => 'Vidéo',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Lien vers la vidéo',
                    ]
            ]);

        $builder->add('state','choice',
            [
                'label' => 'Status',
                'choices' => ['0' => 'Inactif', '1' => 'En cours', '2' => 'En ligne'], //Les choix disponibles
                'preferred_choices' => ['1'], //Le choix par défaut
                'required' => true, //liste déroulante
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

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Cms']);
    }

    /**
    * Retourne le nom du formulaire selon la structure ns_bundle_controller
    * Returns the name of this type.
    *
    * @return string The name of this type
    */
    public function getName()
    {
        return "store_backend_cms";
    }

}
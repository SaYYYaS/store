<?php
namespace Store\BackendBundle\Form;

use Store\BackendBundle\Repository\ProductRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class categoryType
 * Formulaire de création de slider
 * @package Store\BackendBundle\Form
 */
class SliderType extends AbstractType{

    protected $user;

    function __construct($user = null)
    {
        $this->user = $user;

    }
    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité slider

        $builder->add('caption',null,
            [
                'label' => 'Légende',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Légende concernant l\'image',
                    ]
            ]);

        $builder->add('active',null,
            [
                'label' => 'Slide en ligne?',
                'attr' =>
                    [
                        'class' => 'col-centered col-md-12 col-sm-12 checkbox',
                    ]
            ]);

        $builder->add('position',null,
            [
                'label' => 'Position',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-control',
                    ]
            ]);

        $builder->add('file','file',
            [
                'label' => 'Image du slide',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'accept' => 'image/*',
                        'capture' => 'capture'
                    ]
            ]);

        $builder->add('product',null,
            [
                'label' => 'Associé au produit',
                'class' => 'StoreBackendBundle:Product',
                'property' => 'title',
                'query_builder' => function(ProductRepository $er){
                    return $er->getProductByUserBuilder($this->user);
                },
                'attr' =>
                    [
                        'class' => 'form-control'
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
    * Methode qui lie mon formulaire à l'entité slider
    * Car mon formulaire enregistre un slider dans la table slider
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver){
    }

    /**
     * Methode deprécié pour lier un formulaire à une entité
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $resolver->setDefaults(['data_class' => 'Store\BackendBundle\Entity\Slider']);
    }

    /**
    * Retourne le nom du formulaire selon la structure ns_bundle_controller
    * Returns the name of this type.
    *
    * @return string The name of this type
    */
    public function getName()
    {
        return "store_backend_slider";
    }

}
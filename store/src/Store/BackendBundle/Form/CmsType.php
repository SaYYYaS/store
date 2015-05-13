<?php
namespace Store\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class categoryType
 * Formulaire de création de cms
 * @package Store\BackendBundle\Form
 */
class CmsType extends AbstractType{



    /**
     * @var
     */
    private $options;

    public function __construct($options){

        $this->options = $options;
    }

    /**
    * Methode qui va construire le formulaire
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Methode add permet d'ajouter des champs dans le formulaire
        //Le nom de mes champs sont mes attributs de l'entité cms

        $builder->setPropertyPath('CmsType');
        dump($builder->getPropertyPath());
        $builder->add('title',null,
        [
            'label' => 'cms.form.title.label',
            'attr' =>
            [
                'class' => 'form-control',
                'placeholder' => 'cms.form.title.pholder',
            ]
        ]);

        $builder->add('dateActive','date',
            [
                'label' => 'cms.form.date_activation.label',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'date form-control']
            ]);

        $builder->add('summary',null,
            [
                'label' => 'cms.form.summary.label',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'cms.form.summary.pholder',
                    ]
            ]);

        $builder->add('description',null,
            [
                'label' => 'cms.form.description.label',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'cms.form.description.pholder',
                    ]
            ]);

        $builder->add('image','url',
            [
                'label' => 'cms.form.image.label',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'cms.form.image.pholder',
                    ]
            ]);

        $builder->add('video',null,
            [
                'label' => 'cms.form.movie.label',
                'attr' =>
                    [
                        'class' => 'form-control',
                        'placeholder' => 'cms.form.movie.pholder',
                    ]
            ]);
        #TODO :translate choices
        $builder->add('state','choice',
            [
                'label' => 'Status',
                'choices' => $this->options['status'], //Les choix disponibles
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

        //Utilisation d'un event pour mettre en majuscule le titre si < 10
        $builder->get('title')->addEventListener(
            FormEvents::SUBMIT,
            function(FormEvent $event){
                $data = $event->getData();
                if(strlen($data) < 10)
                {
                    $data = strtoupper($data);
                    $event->setData($data);
                }
            }
        );


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

        $resolver->setDefaults([
            'data_class' => 'Store\BackendBundle\Entity\Cms',
            'translation_domain' => 'cms'
        ]);
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
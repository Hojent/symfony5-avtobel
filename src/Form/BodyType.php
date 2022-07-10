<?php

namespace App\Form;

use App\Entity\Body;
use App\Entity\Plan;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BodyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug', TextType::class, [
                       'required' => false,
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#ffffff',
                    //...
                ],
                'required' => false,
            ])
            ->add('images',  TextType::class, [
                'required' => false,
                'attr' => [
                    'id' => 'path',
                ],

            ])
            ->add('published')
            ->add('metatitle', TextType::class, [
                'required' => false,
            ])
            ->add('metadesc', TextareaType::class, [
                'required' => false,
            ])
            ->add('metakey', TextType::class, [
                'required' => false,
            ])
            ->add('bodycategory')

           /* ->add('plans', EntityType::class, [
                // looks for choices from this entity
                'class' => Plan::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                 'multiple' => true,
                 'expanded' => true,*/

/*            ->add('plans', CollectionType::class, [
            'entry_type' => PlanType::class,
            'entry_options' => ['label' => false],
            ])*/
        ;

        $builder->add('save',  SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Body::class,
        ]);
    }
}

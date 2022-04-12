<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false
            ])
            ->add('alias', TextType::class, [
                'required' => false,
            ])
            ->add('category',EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
                'required' => false,
                'placeholder' => 'Нет родительской категории',
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('cat')
                        ->where('cat.published = 1')
                        ;
                },
                'choice_label' => 'title',

            ])
            ->add('introtext', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#fff0ff',
                    //...
                ],
                'required' => false,
            ])
            ->add('fullText', CKEditorType::class, [
                'config_name' => 'full_config',
                'required' => false,
                ])
            ->add('published')
            ->add('featured')
            ->add('created', DateType::class,[
                'required' => false,
                'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
                ]
            ])
        /*    ->add('images',FileType::class,[
                'required' => false,
                'mapped' => false,

            ])*/
           ->add('images',  TextType::class, [
               'required' => false,
               'attr' => [
                   'id' => 'path',
               ],

           ])
            ->add('ordering', NumberType::class , [
                'required' => false,
            ])
            ->add('metatitle' , TextType::class, [
                'required' => false,
            ])
            ->add('metakey', TextType::class, [
                'required' => false,
            ])
            ->add('metadesc', TextareaType::class, [
                'required' => false,
            ])
        ;

        $builder->add('save',  SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,

        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('alias')
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#ffffff',
                    //...
                ],
            ])
            ->add('parent', EntityType::class, [
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
            ->add('published')
            ->add('metadesc')
            ->add('metakey')
           // ->add('created_time')
        ;
        $builder->add('save',  SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

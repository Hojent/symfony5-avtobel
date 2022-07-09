<?php

namespace App\Form;

use App\Entity\BodyCategory;
use App\Repository\BodyCategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BodyCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false
            ])
            ->add('slug', TextType::class, [
                'required' => true,
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#ffffff',
                    //...
                ],
                'required' => false,
            ])
            ->add('image',  TextType::class, [
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
            //->add('createdTime')
        ;
        $builder->add('save',  SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BodyCategory::class,
        ]);
    }
}

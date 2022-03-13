<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('alias')
            ->add('introtext')
            ->add('full_text')
            ->add('state')
            ->add('catid')
            ->add('created')
            ->add('images')
            ->add('urls')
            ->add('ordering')
            ->add('metakey')
            ->add('metadesc')
            ->add('featured')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}

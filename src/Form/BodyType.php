<?php

namespace App\Form;

use App\Entity\Body;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BodyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('description')
            ->add('published')
            ->add('created')
            ->add('images')
            ->add('ordering')
            ->add('metatitle')
            ->add('metadesc')
            ->add('metakey')
            ->add('featured')
            ->add('bodycategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Body::class,
        ]);
    }
}

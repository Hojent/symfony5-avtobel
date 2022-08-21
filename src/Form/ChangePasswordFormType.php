<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['autocomplete' => 'new-password',
                                'class' => 'form-control'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Пожалуйста, введите пароль',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Пароль должен содержать не менее {{ limit }} знаков',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Новый пароль',
                ],
                'second_options' => [
                    'attr' => ['autocomplete' => 'new-password',
                        'class' => 'form-control'],
                    'label' => 'Повторите пароль',
                ],
                'invalid_message' => 'Пароль не совпадают.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

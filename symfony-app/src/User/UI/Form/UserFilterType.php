<?php

namespace App\User\UI\Form;

use App\User\Application\DTO\UserFilterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'male' => 'male',
                        'female' => 'female',
                    ],
                ]
            )
            ->add(
                'birthdateFrom',
                DateType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'birthdateTo',
                DateType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'sort',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        '' => '',
                        'id' => 'id',
                        'first_name' => 'first_name',
                        'last_name' => 'last_name',
                        'birthdate' => 'birthdate',
                        'gender' => 'gender',
                    ],
                ]
            )
            ->add(
                'sortDirection',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'asc' => 'asc',
                        'desc' => 'desc',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => UserFilterDTO::class,
                'method' => 'GET',
                'csrf_protection' => false,
            ]
        );
    }
}
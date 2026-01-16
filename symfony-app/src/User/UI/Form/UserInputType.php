<?php

namespace App\User\UI\Form;

use App\Shared\Domain\Enum\Gender;
use App\User\Application\DTO\UserInputDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserInputType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'First Name',
                    'required' => true,
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Last Name',
                    'required' => true,
                ]
            )
            ->add(
                'birthdate',
                DateType::class,
                [
                    'label' => 'Birthdate',
                    'required' => true,
                    'input' => 'datetime_immutable',
                    'widget' => 'single_text',
                    'html5' => true,
                ]
            )
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'label' => 'Gender',
                    'required' => true,
                    'choices' => [
                        Gender::MALE->value => Gender::MALE->value,
                        Gender::FEMALE->value => Gender::FEMALE->value,
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => UserInputDTO::class,
            ]
        );
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // New profile fields
            ->add('firstName', null, [
                'label' => 'Prénom',
                'required' => false,
                'constraints' => [new Length(max: 100)],
            ])
            ->add('lastName', null, [
                'label' => 'Nom de famille',
                'required' => false,
                'constraints' => [new Length(max: 100)],
            ])
            ->add('age', null, [
                'label' => 'Âge',
                'required' => false,
                'constraints' => [new Positive()],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sexe',
                'required' => false,
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                    'Autre' => 'autre',
                ],
            ])
            ->add('phone', null, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [new Length(max: 30)],
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('country', null, [
                'label' => 'Pays',
                'required' => false,
                'constraints' => [new Length(max: 50)],
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text',
            ])

            // Existing auth fields
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [new NotBlank()],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 6),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}

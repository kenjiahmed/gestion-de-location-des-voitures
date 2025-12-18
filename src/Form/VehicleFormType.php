<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\Brand;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Length;

class VehicleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'label' => 'Marque',
                'constraints' => [new NotBlank()]
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 100])
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'constraints' => [
                    new NotBlank(),
                    new Positive()
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie',
                'constraints' => [new NotBlank()]
            ])
            ->add('pricePerDay', MoneyType::class, [
                'label' => 'Prix par jour (€)',
                'currency' => 'EUR',
                'constraints' => [
                    new NotBlank(),
                    new Positive()
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows' => 4]
            ])
            ->add('color', TextType::class, [
                'label' => 'Couleur',
                'required' => false,
                'constraints' => [new Length(['max' => 20])]
            ])
            ->add('fuelType', ChoiceType::class, [
                'label' => 'Type de carburant',
                'required' => false,
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Hybride' => 'hybride',
                    'Électrique' => 'electrique',
                    'GPL' => 'gpl'
                ]
            ])
            ->add('seats', IntegerType::class, [
                'label' => 'Nombre de places',
                'required' => false,
                'constraints' => [new Positive()]
            ])
            ->add('transmission', ChoiceType::class, [
                'label' => 'Transmission',
                'required' => false,
                'choices' => [
                    'Manuelle' => 'manuelle',
                    'Automatique' => 'automatique',
                    'Semi-automatique' => 'semi-automatique'
                ]
            ])
            ->add('available', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}


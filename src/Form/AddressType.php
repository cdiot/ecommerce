<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'label.name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_name',
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_firstname',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'label.lastname',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_lastname',
                    ])
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'label.company',
                'required' => false,
                'attr' => [
                    'placeholder' => 'placeholder.company'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'label.address',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_address',
                    ])
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'label.postal',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_postal',
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'label.city',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_city',
                    ])
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'label.country',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_country',
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'label.phone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_phone',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'label.validate'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

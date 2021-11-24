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
                'label' => 'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez nommer votre adresse',
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre prénom',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre nom',
                    ])
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Votre Société ?',
                'required' => false,
                'attr' => [
                    'placeholder' => '(facultatif) Veuillez saisir le nom de votre société'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre addresse'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre addresse',
                    ])
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Votre code postale',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre code postale'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre code postale',
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre ville'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre ville',
                    ])
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Votre pays',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre pays'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre pays',
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre téléphone'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer votre téléphone',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

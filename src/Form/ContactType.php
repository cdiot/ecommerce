<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'placeholder.email'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'constraints.type_email',
                    ]),
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'label.subject',
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_subject',
                    ]),
                    new Length(['min' => 3]),
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'label.message',
                'attr' => [
                    'placeholder' => 'placeholder.message'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'constraints.blank_message',
                    ]),
                    new Length(['min' => 10]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'label.send',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

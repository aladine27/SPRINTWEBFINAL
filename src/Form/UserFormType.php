<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nom', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'PLEASE FILL YOUR NAME'
                ])
            ]
        ])
        ->add('Prenom', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'PLEASE FILL YOUR SURNAME'
                ])
            ]
        ])
            ->add('Age', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotNull([
                        'message' => 'Please enter your age',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adresse email ne peut pas être vide.'
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide.'
                    ])
                ]
            ])
           
            
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

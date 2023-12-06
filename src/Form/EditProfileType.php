<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-Mail : ',
                'attr' => [
                    'placeholder' => 'john.doe@mail.com',
                ],
                'constraints' => [
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'E-Mail addresses cannot exceed 180 characters',
                    ])
                    ],
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'label' => 'Username : ',
                
                'attr' => [
                    'placeholder' => 'johnDoe67',
                ],

                'constraints' => [
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Usernames cannot exceed 20 characters',
                    ])
                    ],
                    'required' => false,
            ])

            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords don\'t match',
                'required' => false,
                'first_options'  => [
                    'label' => 'Password : ',
                    "attr" => [
                        "placeholder" => "••••••••",
                        ]
                    ],
                'second_options' => [
                    'label' => 'Password confirmation : ',
                    "attr" => [
                        "placeholder" => "••••••••",
                        ]
                    ],
                'constraints' => [
                    new Length([
                            'min' => 8,
                            'minMessage' => 'Passwords have to be atleast 8 characters',
                            'max' => 30,
                            'maxMessage' => 'Passwords can\'t exceed 30 characters',
                    ])
                ]
            ])
            
            // à faire, changement d'icône parmis les icônes existants
            // ->add('icon')

            ->add('discord', TextType::class, [
                'label' => 'Discord username : ',
                'attr' => [
                    'placeholder' => 'Edmund67',
                ],

                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Discord link cannot exceed 255 characters',
                    ])
                    ],
                    'required' => false,
            ])

            ->add('twitch', TextType::class, [
                'label' => 'Twitch username : ',
                'attr' => [
                    'placeholder' => 'Edmund67',
                ],
                
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Twitch link cannot exceed 255 characters',
                    ])
                    ],
                    'required' => false,
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

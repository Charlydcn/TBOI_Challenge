<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "E-Mail : ",
                "attr" => [
                    "placeholder" => "john.doe@example.fr",
                ],
            ])
            ->add('username', TextType::class, [
                "label" => "Username : ",
                "attr" => [
                    "placeholder" => "McMillen1337",
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Usernames have to be atleast 3 characters',
                        'max' => 20,
                        'maxMessage' => 'Usernames can\'t exceed 20 characters',
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords don\'t match',
                'required' => true,
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

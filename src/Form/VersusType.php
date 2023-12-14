<?php

namespace App\Form;

use DateTime;
use App\Entity\Versus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class VersusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'dd-MM-yyyy HH:mm',
                    'class' => 'date-input',
                ],
                'data' => new DateTime(),
            ])
        
        

            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'dd-MM-yyyy HH:mm',
                    'class' => 'date-input',
                ],
                'required' => false,
            ])

            ->add('slots', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Leave empty for unlimited',
                ],
            ])

            // ->add('public', CheckboxType::class, [
            //     'required' => false,
            //     'data' => true,
            // ])

            ->add('discordChannel', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Discord channel URL can\'t exceed 255 characters',
                    ])
                ],
                'attr' => [
                    'placeholder' => 'https://discord.com/channels/example/example',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Create Versus',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Versus::class,
        ]);
    }
}

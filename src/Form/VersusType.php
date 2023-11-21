<?php

namespace App\Form;

use App\Entity\Versus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class VersusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('startDate', DateTimeType::class, [
                'label' => 'Starting date (optionnal)',
                'input' => 'datetime',
            'placeholder' => [
                'month' => 'Month',
                'day' => 'Day',
                'hour' => 'Hour',
                'minute' => 'Minute',
                'second' => 'Second',
            ],
            'minutes' => range(0, 55, 5),
        ])
        

            ->add('endDate', DateTimeType::class, [
                'label' => 'End date (optionnal)',
                'input' => 'datetime',
                'placeholder' => [
                    'month' => 'Month',
                    'day' => 'Day',
                    'hour' => 'Hour',
                    'minute' => 'Minute',
                    'second' => 'Second',
                ],
                'minutes' => range(0, 55, 5),
            ])

            ->add('slots', NumberType::class, [
                'input' => 'number',
                'label' => 'Slots (empty for unlimited)',
                'html5' => true,
            ])

            ->add('public', CheckboxType::class, [
                'required' => false,
            ])

            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Versus::class,
        ]);
    }
}

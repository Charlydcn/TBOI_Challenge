<?php

namespace App\Form;

use DateTime;
use App\Entity\Versus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                'label' => 'Starting date',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'dd-MM-yyyy HH:mm'
                ],
                'data' => new DateTime(),
            ])
        
        

            ->add('endDate', DateTimeType::class, [
                'label' => 'Ending date (leave empty for none)',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'dd-MM-yyyy HH:mm'
                ],
                'required' => false,
            ])

            ->add('slots', IntegerType::class, [
                'label' => 'Slots (leave empty for unlimited)',
                'required' => false,
            ])

            ->add('public', CheckboxType::class, [
                'required' => false,
                'data' => true,
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

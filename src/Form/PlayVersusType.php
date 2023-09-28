<?php

namespace App\Form;

use App\Entity\PlayVersus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlayVersusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('completionTime', TimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => true,
                'label' => 'Completion time :',
            ])
            // ->add('playDate')
            // ->add('versus')
            // ->add('user')

            ->add('submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayVersus::class,
        ]);
    }
}

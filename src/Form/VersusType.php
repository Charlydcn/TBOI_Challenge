<?php

namespace App\Form;

use App\Entity\Versus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class VersusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timeLimit', TimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => true,
                'required' => false,
                'label' => 'Time limit (optionnal) :',
            ])

            ->add('public', CheckboxType::class, [
                'required' => false,
            ])

            ->add('submit', SubmitType::class)
            // ->add('closed')
            // ->add('challenge')
            // ->add('creator')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Versus::class,
        ]);
    }
}

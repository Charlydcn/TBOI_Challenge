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

            ->add('comment', TextType::class, [
                'label' => 'Comment (50 characters max)',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Comments must be 3 characters max',
                        'max' => 50,
                        'maxMessage' => 'Comments must be 50 characters max',
                    ])
                ]
            ])

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

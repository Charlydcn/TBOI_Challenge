<?php

namespace App\Form;

use App\Entity\PlayChallenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class PlayChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('completionTime', TimeType::class, [
            'widget' => 'single_text',
            'with_seconds' => true,
            'required' => false,
            'label' => 'Time (optionnal) :',
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
                ],
                'required' => false,
        ])

        ->add('submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayChallenge::class,
        ]);
    }
}

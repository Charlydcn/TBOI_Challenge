<?php

namespace App\Form;

use App\Entity\Boss;
use App\Entity\Challenge;
use App\Entity\Character;
use App\Entity\Restriction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('characters', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,

                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Incorrect character(s)',
                        'max' => 25,
                        'maxMessage' => 'Incorrect character(s)'
                    ]),
                ],
            ])

            ->add('bosses', EntityType::class, [
                'class' => Boss::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,

                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Incorrect boss(es)',
                        'max' => 25,
                        'maxMessage' => 'Incorrect boss(es)'
                    ]),
                ],
            ])

            ->add('restrictions', EntityType::class, [
                'class' => Restriction::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,

                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Incorrect restriction(s)',
                        'max' => 50,
                        'maxMessage' => 'Incorrect restriction(s)'
                    ]),
                ],
            ])

            ->add('streak', IntegerType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Restriction chance cannot be less than 1 digit',
                        'max' => 3,
                        'maxMessage' => 'Restriction chance cannot exceed 3 digits'
                    ]),
                ],
            ])
            
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Boss;
use App\Entity\Challenge;
use App\Entity\Character;
use App\Entity\Restriction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

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

                'attr' => [
                    'checked' => false,
                ],
            ])

            ->add('bosses', EntityType::class, [
                'class' => Boss::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,

                'attr' => [
                    'checked' => false,
                ],
            ])

            ->add('restrictions', EntityType::class, [
                'class' => Restriction::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,

                'attr' => [
                    'checked' => false,
                ],
            ])

            ->add('restrictionsChance', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 100,
                    'onkeypress' => 'if (this.value.length > 2) return false;',
                    'name' => 'restr_chance',
                    'step' => 1,
                    'value' => 10,
                    'maxlength' => 3,
                ],
            ])

            ->add('streakCheckbox', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ])

            ->add('streak', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'value' => 0,
                    'maxlength' => 3,
                ],
                            
                'label_attr' => [
                    'class' => 'prevent-select',
                ],

                'constraints' => [
                    new Length([
                        'max' => 10,
                        'maxMessage' => 'Win-streak number is too long',
                    ]),
                ],

                'required' => false,
            ])
            
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'hidden',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}

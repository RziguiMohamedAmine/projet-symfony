<?php

namespace App\Form;

use App\Entity\Matchs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;


class Matchs1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbBut1', NumberType::class,
                [
                    'attr' => [
                        'placeholder' => 'Stade de Match'
                    ]
                ])
            ->add('nbBut2', NumberType::class)
            ->add('stade', TextType::class, [
                'attr' => [
                    'placeholder' => 'Stade de Match'
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'html5' => 'false',
                'constraints' => [new NotBlank(['message' => 'Choisir une date valide']),
                ],
            ])
            ->add('nbSpectateur', NumberType::class,
                [
                    'attr' => [
                        'placeholder' => 'Stade de Match'
                    ]
                ])
            ->add('saison', TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Saison de type YYYY/YYYY'
                    ]
                ])
            ->add('round', NumberType::class,
                [
                    'attr' => [
                        'placeholder' => 'nombre de round'
                    ]
                ])
            ->add('equipe1', null, [
                'placeholder' => 'select La primiere equipe pour ce match'
            ])
            ->add('equipe2', null, [
                'placeholder' => 'select La deuixieme equipe pour ce match'
            ])
            ->add('idArbitre1', null, [
                'label' => 'Arbitre1',
                'placeholder' => 'select Le preimier Arbitre pour ce match'

            ])
            ->add('idArbitre2', null, [
                'label' => 'Arbitre2',
                'placeholder' => 'select Le deuixieme Arbitre pour ce match'

            ])
            ->add('idArbitre3', null, [
                'label' => 'Arbitre3',
                'placeholder' => 'select Le troisieme Arbitre pour ce match'

            ])
            ->add('idArbitre4', null, [
                'label' => 'Arbitre4',
                'placeholder' => 'select Le quatrieme  Arbitre pour ce match'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matchs::class,
        ]);
    }
}

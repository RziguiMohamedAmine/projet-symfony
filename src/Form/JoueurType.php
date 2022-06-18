<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])
            ->add('prenom',TextType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])

            ->add('poste',ChoiceType::class, [
                'choices'  => [
                    'gk' => 'gardien',
                    'cb' => 'defenseur',
                    'rmf' => 'milieu',
                    'cf' => 'attaquant',
                ],
            ])
            ->add('nationalite',TextType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])
            ->add('dateNaiss',DateType::class,
                [
                    'widget' => 'single_text'
                ]
            )
            ->add('taille',NumberType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])
            ->add('poids',NumberType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])
            ->add('image',FileType::class,  array('data_class' => null)

            )


            ->add('idEquipe', EntityType::class, [
                // looks for choices from this entity
                'class' => Equipe::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'nomeq',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Joueur;
use App\Entity\Matchs;
use App\Entity\Matchjoueur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchjoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cartonJaune')
            ->add('cartonRouge')
            ->add('nbBut')
            ->add('idJoueur', EntityType::class, [
                'class' => Joueur::class,
                'choice_label' => 'nom','label'=>'Joueur'
            ])
            ->add('idMatch')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matchjoueur::class,
        ]);
    }
}

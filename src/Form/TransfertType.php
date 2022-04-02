<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Transfert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('idAncieneq', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nomeq',
            ])

            ->add('idJoueur', EntityType::class, [
                'class' => Joueur::class,
                'choice_label' => 'nom',
            ])
            ->add('idNouveaueq', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nomeq',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfert::class,
        ]);
    }
}

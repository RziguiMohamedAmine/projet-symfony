<?php

namespace App\Form;

use App\Entity\Billet;
use App\Entity\Matchs;
use App\Repository\MatchsRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $matchRep = $options['matchRep'];

        $builder
            ->add('bloc', ChoiceType::class, [
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                ],
                'placeholder' => 'Select Bloc',
            ])
            ->add('idMatch', EntityType::class, [
                'class' => Matchs::class,
                'label' => 'Match',
                'placeholder' => 'select match',
                'choices' => $matchRep->getMatchsWithBilletApp(),
                'choice_label' => function (Matchs $choice, $key, $value) {
                    $availble_billet = $choice->getNbSpectateur() - $choice->nbBillet;
                    return $choice->getEquipe1() . ' - ' . $choice->getEquipe2() . ' : ' . $availble_billet;
                },
            ])
            ->add('idUser', null, [
                'label' => 'User'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('matchRep');

        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}

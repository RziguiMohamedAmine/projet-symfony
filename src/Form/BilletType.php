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
                'query_builder' => function (MatchsRepository $matchsRepository) {
//                    $date = new DateTime();
//                    $qb = $matchsRepository->getEntityManager()->createQueryBuilder();
//                    $qb2 = $qb;
//                    $qb2->select('count(b.id)')
//                        ->from('App\Entity\Billet', 'b')
//                        ->where('b.idMatch = :idMatch');
//
//                    $qb = $this->_em->createQueryBuilder();
//                    $qb->select('m')
//                        ->addSelect($qb2->getDQL())
//                        ->from('App\Entity\Matchs', 'm');
//                    $qb2->setParameter('idMacth', 'm.id');
//                    $query = $qb->getQuery();
//
//                    return $query;
                    $date = new DateTime();
                    return $matchsRepository->createQueryBuilder('m')
                        ->where('m.date > :date')
                        ->setParameter('date', $date);
                },
            ])
            ->add('idUser', null, [
                'label' => 'User'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}

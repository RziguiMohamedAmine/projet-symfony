<?php

namespace App\Form;

use App\Entity\Billet;
use App\Repository\ClassementRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idMatch', ChoiceType::class, [
                'choices' => function (ClassementRepository $classementRepository) {
                    $rsult = $classementRepository->createQueryBuilder('c.saison')->distinct()->getQuery()->getArrayResult();
                },
            ]);

    }

//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => Billet::class,
//        ]);
//    }
}

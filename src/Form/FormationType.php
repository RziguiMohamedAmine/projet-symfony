<?php

namespace App\Form;
use App\Entity\Formation;
use App\Entity\Joueur;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{


    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poste')
            ->add('idJoueur',EntityType::class, [
                'class' => Joueur::class,
                'query_builder' => function (EntityRepository $er,int $id) {
                    return $er->createQueryBuilder('j')
                        ->join('j.idEquipe','e')
                        ->addSelect('e')
                        ->where('e.id=:id')
                        ->orderBy('j.poste','asc')
                        ->setParameter('id',id);
                },
                'choice_label' => 'nom','label'=>'Joueur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}

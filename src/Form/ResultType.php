<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipe1', null, [
                'attr' => ['disabled' => 'disabled']
            ])
            ->add('nbBut1', NumberType::class, [
                'label' => 'nombre de but equipe1'
            ])
            ->add('equipe2', null, [
                'attr' => ['disabled' => 'disabled']
            ])
            ->add('nbBut2', NumberType::class, [
                'label' => 'nombre de but equipe2',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

<?php

namespace App\Form;

use App\Validator\SaisonFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TirageAuSortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Saison', TextType::class, [
                'constraints' => [new NotBlank(['message' => 'saison est obligtoire']), new Regex(['pattern' => '/^[0-9]{4}\/[0-9]{4}$/', 'message' => 'saion doit etre de cette format 2020/2021']),
                    new SaisonFormat()]
            ])
            ->add('Date', DateTimeType::class, [
                'label' => 'date de premier Match de Saison',
                'constraints' => [new NotBlank(['message' => 'Date est Obligtoire'])
                ],
                'widget' => 'single_text',
                'input' => 'datetime',
                'html5' => 'false',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

<?php
namespace App\Form;

use App\Entity\Equipe;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomeq', TextType::class,[
                'attr'=>['placeholder'=>'entrer nom'],
            ])
            ->add('logo',FileType::class, array('data_class' => null))

            ->add('nomEntreneur',TextType::class,[
                'attr'=>['placeholder'=>'entrer entreneur'],
            ])
            ->add('niveau',TextType::class,[
                'attr'=>['placeholder'=>'entrer niveau'],
            ])
            ->add('stade',TextType::class,[
                'attr'=>['placeholder'=>'entrer stade'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
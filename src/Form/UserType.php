<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>['placeholder'=>'Email'],
            ])
           // ->add('roles')
            ->add('password',RepeatedType::class, [
                'type'=>PasswordType::class,
                'first_options'=>['label'=>'Password','attr' => ['placeholder' => 'Password']],
                'second_options'=>['label'=>'Confirm Password','attr' => ['placeholder' => 'Confirm Password']]
            ])
            ->add('nom',TextType::class,[
                'attr'=>['placeholder'=>'Nom'],
            ])
            ->add('prenom',TextType::class,[
                'attr'=>['placeholder'=>'Prenom'],
            ])
            ->add('tel',TextType::class,[
                'attr'=>['placeholder'=>'Telephone'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

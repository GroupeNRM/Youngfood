<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Prénom'
            ])
            ->add('gender', ChoiceType::class, [
                'required' => true,
                'label' => 'Sexe',
                'choices' => [
                    'H' => 'H',
                    'F' => 'F',
                    'Inconnue' => 'I'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'row_attr' => [
                    'class' => 'text-center'
                ],
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

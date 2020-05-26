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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('gender', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'H' => 'H',
                    'F' => 'F',
                    'Inconnue' => 'I'
                ]
            ])
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class, [
                'row_attr' => [
                    'class' => 'text-center'
                ],
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            //->add('roles')
            //->add('password')
            //->add('registered_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

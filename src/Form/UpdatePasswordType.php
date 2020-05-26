<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Ancien Mot de Passe',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas !',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères !',
                        'max' => 30,
                        'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères !',
                    ])
                ],
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir votre nouveau mot de passe !',
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Répétez le mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez ressaisir votre nouveau mot de passe !',
                        ]),
                    ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-lg btn-success',
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

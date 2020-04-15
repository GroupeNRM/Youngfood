<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez un prénom'
                    ]),
                    new Length([
                        'max' => '50',
                        'maxMessage' => 'Le prénom peut contenir que {{ limit }} caractères au maximum.',
                    ])
                ],
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez un nom de famille'
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom de famille ne peut contenir que {{ limit }} caractères au maximum.',
                    ])
                ],
                'label' => 'Nom de famille',
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Inconnu' => 'I',
                    'Femme' => 'F',
                    'Homme' => 'H'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre genre.',
                    ])
                ],
                'label' => 'Sexe',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez une adresse e-mail',
                    ]),
                ],
                'label' => 'Email',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
                'required' => true,
            ])
            ->add('verifpassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Renseignez une seconde fois le mot de passe.',
                    ]),
                ],
                'label' => 'Vérification mot de passe',
                'required' => true,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'required' => true,
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

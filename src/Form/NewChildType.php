<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseignez le nom de votre enfant !'
                    ]),
                    new Length([
                        'max' => '50',
                        'maxMessage' => 'Le Nom de l\'Enfant ne peut contenir plus de {{ limit }} caractères !'
                    ])
                ],
                'label' => 'Nom de l\'Enfant',
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseignez le prénom de votre enfant !'
                    ]),
                    new Length([
                        'max' => '50',
                        'maxMessage' => 'Le Prénom de l\'Enfant ne peut contenir plus de {{ limit }} caractères !'
                    ])
                ],
                'label' => 'Prénom de l\'Enfant',
                'required' => true
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseignez la date de naissance de votre enfant !'
                    ])
                ],
                'label' => 'Date de Naissance de l\'Enfant',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}

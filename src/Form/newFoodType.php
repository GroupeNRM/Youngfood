<?php

namespace App\Form;

use App\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class newFoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé de l\'aliment',
                'required' => true,
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Entrée' => 'E',
                    'Plat principal' => 'P',
                    'Dessert' => 'D'
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Suggestion de présentation',
                'mapped' => false,
                'required' => false, //false because if we want to edit it in the future we'll have to upload again the pic, yes that's dumb
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Le fichier est trop volumineux.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Le type {{ type }} n\'est pas accepté. Veuillez réessayer.'
                    ])
                ]
            ])
            ->add('information', TextareaType::class, [
                'label' => 'Information sur le plat',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => '250',
                        'maxMessage' => 'Limite de caractères dépassées : {{ limit }} maximum !',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-lg btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}

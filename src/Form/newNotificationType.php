<?php

namespace App\Form;

use App\Entity\Notification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class newNotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Notif_Title', TextType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un titre à la notification !'
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le Titre de la notification ne peut contenir plus de {{ limit }} caractères !'
                    ])
                ],
                'label' => 'Titre de la notification',
                'required' => true
            ])
            ->add('Notif_Text', TextareaType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un message à la notification !'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le Titre de la notification ne peut contenir plus de {{ limit }} caractères !'
                    ])
                ],
                'label' => 'Message de la notification',
                'required' => true
            ])
            //->add('Notif_Date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
        ]);
    }
}

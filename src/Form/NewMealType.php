<?php

namespace App\Form;

use App\Entity\Food;
use App\Entity\Meal;
use App\Repository\FoodRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewMealType extends AbstractType
{
    private $foodRepository;

    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entree', EntityType::class, [
                'class' => Food::class,
                'query_builder' => $this->foodRepository->findEntree(),
                'placeholder' => 'Choisissez une entrée',
                'label' => 'Entrée',
                'choice_label' => 'title'
            ])
            ->add('main_dish', EntityType::class, [
                'class' => Food::class,
                'query_builder' => $this->foodRepository->findMainDish(),
                'placeholder' => 'Choisissez un plat principal',
                'label' => 'Plat principal',
                'choice_label' => 'title'
            ])
            ->add('dessert', EntityType::class, [
                'class' => Food::class,
                'query_builder' => $this->foodRepository->findDessert(),
                'placeholder' => 'Choisissez un dessert',
                'label' => 'Dessert',
                'choice_label' => 'title'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter !',
                'attr' => [
                    'class' => 'btn btn-lg btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}

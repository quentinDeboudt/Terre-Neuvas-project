<?php

namespace App\Form;

use App\Entity\Dessert;
use Symfony\Component\Form\AbstractType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DessertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class,[
                'label' => 'nom : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Dessert-nom'
                ]
            ])
            ->add('ingredients', TextType::class,[
                'label' => 'ingredients : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Dessert-ingredients'
                ]
            ])
            ->add('prix', TextType::class,[
                'label' => 'prix : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Dessert-prix'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dessert::class,
        ]);
    }
}

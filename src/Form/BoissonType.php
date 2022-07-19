<?php

namespace App\Form;

use App\Entity\Boisson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoissonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class,[
                'label' => 'nom : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Boisson-nom'
                ]
            ])
            ->add('ingredients' ,TextType::class,[
                'label' => 'ingredients : ',
                'required' => false,
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Boisson-ingredients'
                ]
            ])
            ->add('prix' , TextType::class,[
                'label' => 'prix : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Boisson-prix'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boisson::class,
        ]);
    }
}

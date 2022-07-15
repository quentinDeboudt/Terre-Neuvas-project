<?php

namespace App\Form;

use App\Entity\Entree;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-entree-nom'
                ]
            ])
            ->add('ingredients', TextType::class,[
                'label' => 'ingredients : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-entree-ingredients'
                ]
            ])
            ->add('prix', TextType::class,[
                'label' => 'prix : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-entree-prix'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}

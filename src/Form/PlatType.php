<?php

namespace App\Form;

use App\Entity\Plat;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class,[
                'label' => 'nom : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Plat-nom'
                ]
            ])
            ->add('ingredients', TextType::class,[
                'label' => 'nom : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Plat-ingredients'
                ]
            ])
            ->add('prix', TextType::class,[
                'label' => 'prix : ',
                'attr' => [
                    'class' => 'form-menu',
                    'id' => 'form-menu-Plat-prix'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plat::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Entree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('brochure', FileType::class, [
                'label' => 'Image :',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1044k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Veuillez ajouter un type d\'image valide',
                    ])
                ],
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

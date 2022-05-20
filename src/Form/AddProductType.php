<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label' =>'Nom Produit',
                'attr' => [
                    'placeholder' => 'Nom du Produit',
                    'class' => 'mt-3 mb-3 form-control',
            ]])
            // ->add('createdAt')
            ->add('imagePath',TextType::class, [
                'label' =>'Photo',
                'attr' => [
                    'placeholder' => 'Lien de la photo',
                    'class' => 'mt-3 mb-3 form-control',
            ]])
            // ->add('isActive')
            // ->add('createdBy')
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => [
                    'class' => 'btn btn-warning'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('words', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer un ou plusieurs mots-clés',
                    'class' => 'input-element'
                ],
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'attr' => [
                    'class' => 'input-element',
                ],
                'required' => false
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn form-btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

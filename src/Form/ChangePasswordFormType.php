<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/',
                            'message' => 'Erreur, votre mot de passe doit  avoir de 8 à 15 caractères, au moins une lettre minuscule, au moins une lettre majuscule, au moins un chiffre, au moins un de ces caractères spéciaux: $ @ % * + - _ ! et aucun autre caractère possible: pas de & ni de { par exemple)'
                        ])
                    ],
                    'label' => 'Tapez votre mot de passe',
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                ],
                'invalid_message' => 'Erreur. Les deux mots de passes ne correspondent pas',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
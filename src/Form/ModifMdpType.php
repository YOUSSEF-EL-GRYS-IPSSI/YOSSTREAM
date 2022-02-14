<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifMdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe actuel',
                'required' => true,
                'attr' => [
                  'placeholder' => 'Veuillez saisir votre ancien mot de passe'
              ]
            ])
            ->add('newplainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => ' Les deux mots de passe ne sont pas identiques',
                'label' => 'Votre nouveau mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => "Mon nouveau mot de passe",
                    'attr' => [
                        'placeholder' => 'Saisissez votre nouveau de mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau de mot passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre nouveau mot de passe'
                    ]
                ]
            ])
            ->add('Modifier', SubmitType::class, [
                'label' => "Mettre à jour"
            ])
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

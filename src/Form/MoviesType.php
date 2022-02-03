<?php

namespace App\Form;

use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MoviesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [ "label" => "Titre du films",
        "required" => false,
        "attr" => [
            "placeholder" => " ajouter le titre du film"
            
        ],
        "constraints" => [
            new NotBlank([
                "message" => "Veuillez entrer un titre"
            ]),
            new Length([
                "min" => 3,
                "max" => 20,
                "minMessage" => "Veuillez saisir 3 caractères minimum",
                "maxMessage" => "Veuillez saisir 20 caractères maximum"
            ])
        ]
        ])

        ->add('description', TextareaType::class, [
            "label" => "Description ",
            "required" => false,
            "attr" => [
                "row" => 4
            ]
            ]);
        
        
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
        ]);
    }
}

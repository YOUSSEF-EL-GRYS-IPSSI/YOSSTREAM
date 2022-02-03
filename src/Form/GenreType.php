<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', TextType::class, [ "label" => "Titre du genre",
        "required" => false,
        "attr" => [
            "placeholder" => "Saisir le genre",
            "class" => "bg-light"
        ],
        "constraints" => [
            new NotBlank([
                "message" => "Veuillez saisir un genre"
            ]),
            new Length([
                "min" => 4,
                "max" => 20,
                "minMessage" => "Veuillez saisir 4 caractères minimum",
                "maxMessage" => "Veuillez saisir 20 caractères maximum"
            ])
        ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
        ]);
    }
}

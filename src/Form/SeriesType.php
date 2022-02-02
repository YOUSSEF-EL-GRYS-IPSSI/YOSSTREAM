<?php

namespace App\Form;

use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [ "label" => "Titre de la série",
        "required" => false,
        "attr" => [
            "placeholder" => "Saisir le titre de la série",
            "class" => "bg-light"
        ],
        "constraints" => [
            new NotBlank([
                "message" => "Veuillez saisir un titre"
            ]),
            new Length([
                "min" => 4,
                "max" => 20,
                "minMessage" => "Veuillez saisir 4 caractères minimum",
                "maxMessage" => "Veuillez saisir 20 caractères maximum"
            ])
        ]
        ])

        ->add('description', TextareaType::class, [
            "label" => "Description (facultatif)",
            "required" => false,
            "attr" => [
                "row" => 4
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
        ]);
    }
}

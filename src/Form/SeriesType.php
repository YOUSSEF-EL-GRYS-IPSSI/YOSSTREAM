<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [ "label" => "Titre de la série",
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

        ->add('genre', EntityType::class, [ // Relation
            "class" => Genre::class,        // Avec quelle class
            "choice_label" => "type",           // Quelle propriété afficher
            "placeholder" => "Sélectionnez un genre",
            "multiple" => true,
            "expanded" => true
            //"expanded" => true soit radio pour une valeur soit checkbox pour plusieurs valeurs 
        ])
        ;
        
        if($options['ajouter'])
            {
                $builder->add('image', FileType::class, [
                    "required" => false,
                    //"multiple" => true,
                        
                ]);
            }

            elseif($options['modifier'])
            {
                $builder->add('imageFile', FileType::class, [
                    "required" => false,
                    "mapped" => false,

                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
            'ajouter' => false,
            'modifier' => false
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        ->add('titre', TextType::class, [ 
        "label" => "Titre du film",
        "required" => false,
        "attr" => [
            "placeholder" => " ajouter le titre du film",
            
        ],
        'label_attr'=>[
            'class'=>'labelInput'

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
             "attr" => ["row" => 4]])
        

        
        // ->add('genre', EntityType::class, [
        //         "class" => Genre::class,
        //         "required" => false,
        //         "choice_label" => "nom",
        //         "attr" => [
        //             "placeholder" => "Sélectionnez un genre"
        //         ],
        //         "multiple" => true,
        //         "expanded" => true

        //     ]);
        ->add('genre', EntityType::class, [ // Relation
            "class" => Genre::class,        // Avec quelle class
            "choice_label" => "type",           // Quelle propriété afficher
            "placeholder" => "Sélectionnez un genre",
            "multiple" => true,
            "expanded" => true
            //"expanded" => true soit radio pour une valeur soit checkbox pour plusieurs valeurs 
        ]);
        
        
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


            if($options['ajouter'])
            {
                $builder->add('video', FileType::class, [
                    "required" => false,
                    //"multiple" => true,
                        
                ]);
            }

            elseif($options['modifier'])
            {
                $builder->add('videoFile', FileType::class, [
                    "required" => false,
                    "mapped" => false,

                ]);
            }
    }
        
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
            'ajouter' => false,
            'modifier' => false
        ]);
    }
}

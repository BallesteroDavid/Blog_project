<?php

namespace App\Form;

use App\Entity\ArticleAnimal;
use App\Entity\OriginCountry;
use App\Entity\Species;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleAnimalType extends AbstractType
{
    // Construction du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ texte pour le nom de l'animal
            ->add('Animal_name', TextType::class, [
                'label' => "Animal's name",
                'attr' => [
                    'placeholder' => "Enter the animal's name"
                ]
            ])

            // Champ de choix pour le statut de l'animal
            ->add('Status', ChoiceType::class, [
                'label' => 'Status',
                'placeholder' => 'Status',
                'choices' => [
                    'Danger' => 1,
                    'Vulnerable' => 2,
                    'Minor Preoccupation' => 3,
                    'Not Evaluated' => 4,
                ],
            ])

            // Champ texte pour l'âge
            ->add('Age', TextType::class, [
                'label' => 'Age',
                'attr' => [
                    'placeholder' => 'Enter your age'
                ]
            ])

            // Zone de texte pour une description détaillée
            ->add('Content', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Content'
                ]
            ])

            // Champ lié à une entité "Type" (relation avec Doctrine)
            ->add('Type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'label' => 'Type',
                'placeholder' => 'Type'
            ])

            // Champ pour uploader une image (non mappé à l'entité)
            ->add('img', FileType::class, [
                'label' => 'illustration',
                'mapped' => false
            ])

            // Champ texte pour l'espèce (ici pas lié à l'entité Species)
            ->add('Species', TextType::class, [
                'label' => "Espèce",
                'attr' => [
                    'placeholder' => "Animal species"
                ]
            ])

            // Champ lié à une entité "OriginCountry" (relation avec Doctrine)
            ->add('Origin_country', EntityType::class, [
                'class' => OriginCountry::class,
                'choice_label' => 'Country',
                'label' => 'Origin Country',
                'placeholder' => 'Origin Country'
            ])
        ;
    }

    // Configuration des options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Le formulaire sera lié à l'entité ArticleAnimal
            'data_class' => ArticleAnimal::class,
        ]);
    }
}

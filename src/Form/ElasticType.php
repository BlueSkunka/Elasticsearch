<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ElasticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom ',
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom ',
                'required' => false
            ])
            ->add('presentation', TextareaType::class, [
                'label' => 'Présentation ',
                'required' => false
            ])
            ->add('categorie', TextType::class, [
                'label' => 'Catégorie ',
                'required' => false,
                'attr' => ['placeholder' => 'Séparé par une virgule']
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

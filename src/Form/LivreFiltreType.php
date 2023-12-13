<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Editeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LivreFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'mapped'=>false,
            'required'=>false,
            'attr'=>['placeholder'=>'Rechercher']
        ])
        ->add('auteur', EntityType::class, [
            'required'=>false,
            'mapped'=>false,
            'placeholder'=>'Tous',
            'class' => Auteur::class
        ])
        ->add('editeur', EntityType::class, [
            'required'=>false,
            'mapped'=>false,
            'placeholder'=>'Tous',
            'class' => Editeur::class
        ])
        // ->add('Submit', SubmitType::class, [
        //     'label'=>'Rechercher'
        // ])
        ;
    }
}

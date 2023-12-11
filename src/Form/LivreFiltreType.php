<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Editeur;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LivreFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ->add('submit', SubmitType::class);
    }
}

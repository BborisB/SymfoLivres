<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', PasswordType::class, [
            'mapped'=>false,
            'label'=>'Mot de passe actuel'
        ])
        ->add('newPassword', RepeatedType::class, [
            'type'=>PasswordType::class,
            'invalid_message'=>'Les mots de passe ne correspondent pas.',
            "first_options"=>[
                "label"=>"Nouveau mot de passe",
                "constraints"=>[new Assert\NotBlank(message:"Entrez un nouveau mot de passe.")]
                ],
            "second_options"=>[
                "label"=>"Confirmation nouveau mot de passe",
                "constraints"=>[new Assert\NotBlank(message:"Confirmez votre nouveau mot de passe.")]
            ],
        ])
        ->add('submit', SubmitType::class, [
            'label'=>'Enregistrer'
        ]);
    }
}

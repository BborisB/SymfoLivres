<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', options:[
                'label'=>'Email',
                'constraints'=>[
                    new Assert\Email(message:"")
                ]
            ])
            ->add('nom', options:[
                'label'=>'Nom',
                'constraints'=>[
                    new Assert\Length(min:3, max:50, minMessage:"", maxMessage:""),
                    new Assert\NotBlank(message:"")
                ]
            ])
            ->add('prenom', options:[
                'label'=>'Prenom',
                'constraints'=>[
                    new Assert\Length(min:3, max:50, minMessage:"", maxMessage:""),
                    new Assert\NotBlank(message:"")
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                "type"=>PasswordType::class,
                "mapped"=>false,
                "first_options"=>[
                    "label"=>"Mot de passe",
                    "constraints"=>[new Assert\NotBlank(message:"Entrez un mot de passe.")]
                    ],
                "second_options"=>[
                    "label"=>"Confirmation mot de passe",
                    "constraints"=>[new Assert\NotBlank(message:"Confirmez votre mot de passe.")]
                ],
                "invalid_message"=>"Les mots de passe ne correspondent pas."
            ])
            ->add('rgpd')
            ->add('submit', SubmitType::class, [
                'label'=>"S'enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

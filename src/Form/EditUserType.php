<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pfp', FileType::class, [
            'label' => 'Image de profil',
            'mapped' => false,
            'required' => false,
            'attr'=>[
                'accept'=>'image/*'
            ],
            'constraints' => [
                new Assert\Image(mimeTypesMessage:"Choisissez une image valide.", maxSize:"1024k", maxSizeMessage:"Votre image est trop lourde.")
            ],
        ])
        ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

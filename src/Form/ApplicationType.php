<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'Renseignez votre adresse mail'
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => new Length(['min' => 2, 'max' => 30]),
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new Length(['min' => 2, 'max' => 30]),
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom de famille'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo de profil'
            ])
            ->add('description', TextType::class, [
                'constraints' => new Length(['min' => 30, 'max' => 500]),
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Quelles sont vos compétences ? Pourquoi devenir formateur ?'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne coïncident pas.',
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Choisissez un mot de passe'
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe'
                ]
            ])
            ->add('termsAccepted', CheckboxType::class, array(
                'mapped' => false,
                'constraints' => new IsTrue(),
                'label' => "Merci d'accepter les termes et conditions",
            ))
            ->add('submit', SubmitType::class, [
                'label' => "C'est parti !",
                'attr' => [
                    'class' => 'btn-success custom-btn rounded-pill'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

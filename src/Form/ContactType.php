<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => new Length(['min' => 7, 'max' => 30]),
                'attr' => [
                    'placeholder' => 'Renseignez votre adresse mail'
                ]
            ])
            ->add('name', TextType::class, [
                'constraints' => new Length(['min' => 3, 'max' => 30]),
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Renseignez votre un nom'
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => new Length(['min' => 25, 'max' => 450]),
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Ecrivez votre message'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Envoyer",
                'attr' => [
                    'class' => 'btn-success custom-btn rounded-pill'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

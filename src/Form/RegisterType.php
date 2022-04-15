<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
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
            ->add('pseudo', TextType::class, [
                'constraints' => new Length(['min' => 2, 'max' => 30]),
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Choisissez un pseudo'
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
                'help' => '<a href="/termes-conditions">consulter</a>',
                'help_html' => true,
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

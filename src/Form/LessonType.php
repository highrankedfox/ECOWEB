<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => new Length(['min' => 5, 'max' => 30]),
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Indiquez le titre de la leçon'
                ]
            ])
            ->add('video', UrlType::class, [
                'constraints' => new Length(['min' => 5, 'max' => 30]),
                'label' => 'URL de la vidéo',
                'attr' => [
                    'placeholder' => 'Entrez le lien de la vidéo correspondant au cours'
                ]
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu de la section'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class' => 'btn-success custom-btn rounded-pill'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}

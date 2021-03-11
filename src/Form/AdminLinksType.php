<?php

namespace App\Form;

use App\Entity\Links;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminLinksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre du lien'
                ]
            ])
            ->add('text', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('url', EmailType::class, [
                'required' => true,
                'label' => 'Adresse du site',
                'attr' => [
                    'placeholder' => 'ex: https://monsite.com'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Jeu' => 1, 
                    'Video' => 2
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Links::class,
        ]);
    }
}

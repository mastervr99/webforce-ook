<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCompleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('phone', TextType::class,
                [
                    'label' => 'Téléphone',
                    'required' => false
                ])

            ->add('postalCode', TextType::class,
                [
                    'label' => 'Code postal',
                    'required' => false
                ])

            ->add('adress',TextType::class,
                [
                    'label' => 'Adresse',
                    'required' => false
                ])

            ->add('city', TextType::class,
                [
                    'label' => 'Ville',
                    'required' => false
                ])

            ->add('photo',FileType::class,
                [
                    'label' => 'Photo',
                    'required' => false
                ])

            ->add('emploi', TextType::class,
                [
                    'label' => 'Emploi',
                    'required' => false
                ])
            ->add('dateBirth',DateType::class,
                [
                    'label' => 'Date de naissance',
                    'required' => false
                ])

            ->add('notePerso', TextareaType::class,
                [
                    'label' => 'Note perso',
                    'required' => false
                ])
            ->add('email', EmailType::class,
                [
                    'label' => 'Email '
                ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

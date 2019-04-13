<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',
                TextType::class,
                [
                    'label' => 'Nom'
                ]

            )
            ->add('prenom',
                TextType::class,
                [
                    'label' => 'Prénom'
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email'
                ]
            )
            ->add('dateDeNaissance',
                    BirthdayType::class,
                [
                    'label' => 'Date de naissance',
                    'format' => 'dd MM yyyy',
                    'required' => false
                ]
            )
            ->add('telephone',
                TextType::class,
                [
                    'label' => 'Téléphone',
                    'required' => false
                ]

            )
            ->add('profession',
                TextType::class,
                [
                    'label' => 'Profession',
                    'required' => false
                ]

            )
            ->add('adresse',
                TextType::class,
                [
                    'label' => 'Adresse',
                    'required' => false
                ]

            )
            ->add('notePersonnelle',
                TextareaType::class,
                [
                    'label' => 'Note Personnelle',
                    'required' => false
                ]
            )
            ->add('codePostal',
                TextType::class,
                [
                    'label' => 'Code postal',
                    'required' => false
                ]

            )
            ->add('ville',
                TextType::class,
                [
                    'label' => 'Ville',
                    'required' => false
                ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

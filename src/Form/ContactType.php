<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'label' => 'Nom',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]

            )
            ->add('prenom',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add('dateDeNaissance',
                    BirthdayType::class,
                [
                    'label' => 'Date de naissance',
                    'format' => 'dd MM yyyy',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add('telephone',
                TextType::class,
                [
                    'label' => 'Téléphone',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]

            )
            ->add('profession',
                TextType::class,
                [
                    'label' => 'Profession',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]

            )
            ->add('adresse',
                TextType::class,
                [
                    'label' => 'Adresse',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]

            )
            ->add('notePersonnelle',
                TextareaType::class,
                [
                    'label' => 'Note Personnelle',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add('codePostal',
                TextType::class,
                [
                    'label' => 'Code postal',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]

            )
            ->add('ville',
                TextType::class,
                [
                    'label' => 'Ville',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control'
                        ]
                ]
            )
            ->add('photo',
                FileType::class,
                [
                    'label' => 'Modifier la photo :',
                    'required' => false,
                    'attr' =>
                        [
                            'id' => 'photo-contact',
//                            'id' => 'photoUpload',
                            'class' => 'attachment_upload'
                        ]

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

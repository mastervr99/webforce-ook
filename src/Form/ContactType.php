<?php

namespace App\Form;

use App\Entity\Contact;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('dateDeNaissance')
            ->add('telephone')
            ->add('profession')
            ->add('adresse')
            ->add('notePersonnelle')
            ->add('codePostal')
            ->add('ville')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

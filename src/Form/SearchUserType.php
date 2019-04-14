<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('lastname',
                TextType::class,
                    [
                        'label' => 'Nom',
                        'required' => false
                    ]
            )
            ->add('firstname',
            TextType::class,
                [
                    'label' => 'Prénom',
                    'required' => false
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'required' => false
                ]
            )
            ->add('city',
                TextType::class,
                [
                    'label' => 'Ville',
                    'required' => false
                ]
            )
            ->add('postalCode',
                TextType::class,
                [
                    'label' => 'Code Postal',
                    'required' => false
                ]
            )
            ->add('emploi',
                TextType::class,
                [
                    'label' => 'Profession',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

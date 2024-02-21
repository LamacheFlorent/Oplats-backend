<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [

                    'Utilisateur' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],

                'multiple' => true,

                'expanded' => true,
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

                $form = $event->getForm();

                $user = $event->getData();

                if ($user->getId() !== null) {

                    $form->add('email', EmailType::class, [
                        'label' => 'E-mail',

                        'empty_data' => '',
                    ])
                    ->add('roles', ChoiceType::class, [
                        'label' => 'Rôles',
                        'choices' => [

                            'Utilisateur' => 'ROLE_USER',
                            'Manager' => 'ROLE_MANAGER',
                            'Administrateur' => 'ROLE_ADMIN',
                        ],

                        'multiple' => true,

                        'expanded' => true,
                    ])
                    ->add('password', null, [
                        'label' => 'Nouveau mot de passe',

                        'mapped' => false,
                    ]);
                }
                else {
                    $form->add('password', RepeatedType::class, [

                        'type' => PasswordType::class,

                        'invalid_message' => 'Les mots de passe ne correspondent pas.',

                        'options' => ['attr' => ['class' => 'password-field']],
                        'required' => true,

                        'first_options'  => ['label' => 'Mot de passe'],

                        'second_options' => ['label' => 'Confirmer le mot de passe'],
                    ]);
                }
            })

            ->add('password', RepeatedType::class, [

                'type' => PasswordType::class,
    
                'invalid_message' => 'Les mots de passe ne correspondent pas.',

                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,

                'first_options'  => ['label' => 'Mot de passe'],

                'second_options' => ['label' => 'Confirmer le mot de passe'],
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


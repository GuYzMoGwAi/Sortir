<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('email')
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
//            ->add('plainPassword', PasswordType::class, [
//                // instead of being set onto the object directly,
//                // this is read and encoded in the controller
//                'mapped' => false,
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Veuillez saisir un mot de passe',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe ne sont pas identiques",
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer'],
                'mapped' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

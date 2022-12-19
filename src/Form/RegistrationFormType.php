<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Groups;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('roles',ChoiceType::class,[
                'multiple'=>true,
                'attr'=>['class'=>'selectpicker col-4'],
                'choices' =>[
                    'Admin'=>'ROLE_ADMIN',
                    'Owner'=>'ROLE_OWNER',
                    'Manager'=>'ROLE_MANAGER',
                ]
            ])
            ->add('adminGroup',EntityType::class,[
                'class'=>Groups::class,
                'attr'=>['class'=>'selectpicker col-4'],
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Not Set',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'compound'=>true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}

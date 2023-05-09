<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',RepeatedType::class,[
                'invalid_message' => 'Emails must match.',
                'required' => true,
                'first_options'  => ['label' => 'Email'],
                'second_options' => ['label' => 'Confirm Email'],
                'constraints'=>[
                    new Email(['message'=>'Please enter a valid email'])
                ]

            ])
            ->add('name')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
                'constraints' => $this->getConstraints()

            ])
        ;
    }
    protected function getConstraints(): array
    {
        return [
            new NotBlank(),
            new Type('string'),
            new Length(['min' => 8]),
            new Regex([
                'pattern' => '/\d+/i',
                'message'=>'password Should contains at least 1 digit'
            ]),
            new Regex([
                'pattern' => '/[#?!@$%^&*-]+/i',
                'message'=>'password Should contains at least 1 special char'
            ]),
            new Regex([
                'pattern' => '/[a-z]+/i',
                'message'=>'password Should contains at least 1 lower case char'
            ]),
            new Regex([
                'pattern' => '/[A-Z]+/i',
                'message'=>'password Should contains at least 1 upper case char'
            ])
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, [
                        'required' => true,
                        'label' => 'Wpisz swoje aktualne hasło.',
                        ])
                ->add('newPassword', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'Hasła się nie zgadzają.',
                        'first_options'  => ['label' => 'Wpisz swoje nowe hasło'],
                        'second_options' => ['label' => 'Wpisz hasło jak powyżej.']    
                 ]);                 
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChangePassword::class,
        ));
    }

    public function getName()
    {
        return 'change_passwd';
    }
}
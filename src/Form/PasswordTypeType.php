<?php

namespace App\Form;

use App\Entity\Password;
use Symfony\Component\Form\RegistrationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array('attr'=>['autocomplete' => 'off']))
            ->add('url',TextType::class,array('attr'=>['autocomplete' => 'off']))
            ->add('password',PasswordType::class,array('attr'=>['autocomplete' => 'off'])
              );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Password::class,
        ]);
    }
}

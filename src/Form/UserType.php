<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, array(
              // 'empty_data' => 'John Doe',
            ))
            ->add('phone',TextType::class, array(
              // 'empty_data' => 'John Doe',
            ))
            ->add('email',EmailType::class, array(

            ))
            ->add('plainPassword', RepeatedType::class, array(

                'type' => TextType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'form.password',  'empty_data'=>'test'),
                'second_options' => array('label' => 'form.password_confirmation',  'empty_data'=>'test'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }
    public function getParent()
  {
      return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }
  public function getBlockPrefix()
   {
       return 'app_user_registration';
   }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Date;
use App\Entity\User;
use App\Entity\DateSchedule;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',TextType::class,array('attr'=>['autocomplete' => 'off']))
            ->add('city',TextType::class,array('attr'=>['autocomplete' => 'off']))
            ->add('day',DateType::class,array('attr'=>['autocomplete' => 'off']))
            ->add('schedule', EntityType::class, array(
              'class' => DateSchedule::class,
              'expanded'     => true,
              'multiple'     => true,
              'choice_label' => 'name',
          ))
              ->add('users', EntityType::class, array(
                'class' => User::class,
                'expanded'     => true,
                'multiple'     => true,
                'choice_label' => 'username',
            ))
              ->add('save', SubmitType::class, array(
                  'attr' => array('class' => 'save'),
              ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Date::class,
            'allow_extra_fields' => true
        ]);
    }
}

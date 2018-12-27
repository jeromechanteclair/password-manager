<?php

namespace App\Form;

use App\Entity\DateSchedule;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateScheduleEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextAreaType::class,array(
                'attr'=>['autocomplete' => 'off'])
                )

            ->add('startTime',DateType::class,array(
                'attr'=>['autocomplete' => 'off'])
                )
            ->add('endTime',DateType::class,array(
                'attr'=>['autocomplete' => 'off']))
            ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateSchedule::class,
            'allow_extra_fields' => true
        ]);
    }
}

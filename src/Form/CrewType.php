<?php

namespace App\Form;

use App\Entity\Crew;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array('attr'=>['autocomplete' => 'off'],))
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
            'data_class' => Crew::class,
        ]);
    }
}

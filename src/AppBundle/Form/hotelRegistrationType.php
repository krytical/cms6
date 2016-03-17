<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HotelRegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Note to avoid having to use data transformers
        // (http://symfony.com/doc/2.8/cookbook/form/data_transformers.html)
        // our foreign keys bypass the form and are added later in the controller.
        // This means our foreign keys are set to null by default in the form.
        $builder->add('checkInDatetime', Type\DateTimeType::class)
        ->add('checkOutDatetime', Type\DateTimeType::class)
        ->add('room')
        ->add('hotel', EntityType::class, array(
            'class' => 'AppBundle:Hotel',
            'choice_label' => 'name',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('HotelRegistration'),
            'data_class' => 'AppBundle\Entity\HotelRegistration'
        ));
    }

}
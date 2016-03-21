<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type;

class ConferenceRegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Note to avoid having to use data transformers
        // (http://symfony.com/doc/2.8/cookbook/form/data_transformers.html)
        // our foreign keys bypass the form and are added later in the controller.
        // This means our foreign keys are set to null by default in the form.
        $builder->add('flightNumber', Type\TextType::class, array(
        'required' => false,
        'label' => 'Flight Number (leave blank if not flying to conference)'))
        ->add('arrivalDatetime', Type\DateTimeType::class, array(
            'required' => false,
            'label' => 'Arrival Flight Time (leave blank if not flying to conference)'))
        ->add('departureDatetime', Type\DateTimeType::class, array(
            'required' => false,
            'label' => 'Departure Flight Time (leave blank if not flying to conference)'))
        ->add('guests', Type\IntegerType::class, array(
            'label' => 'Number Of Attendees in your group (including you)',
            'data' => 1))
        ->add('needsAccommodation', Type\CheckboxType::class, array(
            'required' => false,
            'label' => 'I Need Accommodation (Hotel or Home-stay)'))
        ->add('additionalInfo', Type\TextareaType::class, array(
            'required' => false,
            'label' => 'Please Specify Any Additional Information (required care packages, wheelchair access...)'))
        ->add('approved', Type\HiddenType::class, array(
            'data' => 'false'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('ConferenceRegistration'),
            'data_class' => 'AppBundle\Entity\ConferenceRegistration'
        ));
    }

}
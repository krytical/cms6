<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        # Note conference_id will be added in the controller
        $builder->add('name', Type\TextType::class, array(
            'label' => 'Event Name'
        ))
        ->add('shortDescription', Type\TextareaType::class, array(
            'label' => 'Enter a brief summary of the event'
        ))
        ->add('fullDescription', Type\TextareaType::class, array(
            'label' => 'Enter a full description of the event to be displayed on the event page'
        ))
        ->add('location', Type\TextType::class, array(
            'empty_data'  => 'TBA',
            'label' => 'Event Location (optional)'
        ))
        ->add('speaker', Type\TextType::class, array(
            'empty_data'  => 'TBA',
            'label' => 'Speaker/Host (optional)'
        ))
        # TODO: make these fields a calendar
        ->add('startDatetime', Type\DateTimeType::class, array(
            'label' => 'Event Start Time'
        ))
        ->add('endDatetime', Type\DateTimeType::class, array(
            'label' => 'Event End Time'
        ))
        ->add('capacity', Type\IntegerType::class, array(
            'required' => false,
            'label' => 'Event Capacity (optional)'
        ))
        ->add('imageFile', Type\FileType::class, array(
            'required' => false,
            'label' => 'Event Photo (optional)'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Event'),
            'data_class' => 'AppBundle\Entity\Event',
        ));
    }

}
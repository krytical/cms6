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
        $builder->add('name')
        ->add('shortDescription', Type\TextareaType::class, array(
            'label' => 'Enter a brief summary of the conference'
        ))
        ->add('fullDescription', Type\TextareaType::class, array(
            'label' => 'Enter a full description of the conference to be displayed on the conference page'
        ))
        ->add('location')
        ->add('speaker')
        ->add('startDatetime', Type\DateTimeType::class)
        ->add('endDatetime', Type\DateTimeType::class)
        ->add('capacity', Type\IntegerType::class, array(
            'required' => false,
            'label' => 'Event Capacity'
        ))
        ->add('spotsRemaining', Type\IntegerType::class, array(
            'required' => false,
            'label' => 'Event Seats Remaining'
        ))
        ->add('imageFile', Type\FileType::class, array(
            'required' => false,
            'label' => 'Event Photo'
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
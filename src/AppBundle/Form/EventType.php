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
        ->add('location')
        ->add('speaker')
        ->add('startDatetime')
        ->add('endDatetime')
        ->add('capacity')
        ->add('spotsRemaining')
        ->add('description', Type\TextareaType::class)
        ->add('imageFile', Type\FileType::class, array(
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
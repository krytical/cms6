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
        $builder->add('arrivalDatetime', Type\DateTimeType::class)
        ->add('departureDatetime', Type\DateTimeType::class)
        ->add('guests')
        ->add('accommodations', Type\TextareaType::class, array(
            'label' => 'Additional Requirements'
        ))
        ->add('approved', Type\HiddenType::class, array(
            'data' => 'false'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('ConferenceRegistration'),
            'data_class' => 'AppBundle\Entity\ConferenceRegistration'
        ));
    }

}
<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', Type\TextType::class, array(
            'label' => 'Conference Name'
        ))
        ->add('shortDescription', Type\TextareaType::class, array(
            'label' => 'Enter a brief summary of the conference'
        ))
        ->add('fullDescription', Type\TextareaType::class, array(
            'label' => 'Enter a full description of the conference to be displayed on the conference page'
        ))
        ->add('location', Type\TextType::class, array(
            'empty_data'  => 'TBA',
            'label' => 'Conference Location (optional)'
        ))
        ->add('startDatetime', Type\DateTimeType::class, array(
            'label' => 'Conference Start Time'
        ))
        ->add('endDatetime', Type\DateTimeType::class, array(
            'label' => 'Conference End Time'
        ))
        ->add('imageFile', Type\FileType::class, array(
            'required' => false,
            'label' => 'Conference Photo (optional)'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Conference'),
            'data_class' => 'AppBundle\Entity\Conference',
        ));
    }

}
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
        $builder->add('name');
        $builder->add('description', Type\TextareaType::class);
        $builder->add('location');
        $builder->add('startDatetime', Type\DateTimeType::class);
        $builder->add('endDatetime', Type\DateTimeType::class);
        $builder->add('imageFile', Type\FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Conference'),
            'data_class' => 'AppBundle\Entity\Conference',
        ));
    }

}
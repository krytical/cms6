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
        $builder->add('name');
        $builder->add('location');
        $builder->add('speaker');
        $builder->add('startDatetime');
        $builder->add('endDatetime');
        $builder->add('capacity');
        $builder->add('spotsRemaining');
        $builder->add('imgName');
        $builder->add('description', Type\TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event',
        ));
    }

}
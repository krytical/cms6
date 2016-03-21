<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', Type\TextType::class, array(
            'label' => 'Hotel Name'
        ))
        ->add('location', Type\TextType::class, array(
            'label' => 'Hotel Location'
        ))
        ->add('capacity', Type\IntegerType::class, array(
            'required' => false,
            'label' => 'Hotel Capacity (optional)'
        ))
        ->add('vacancy', Type\IntegerType::class, array(
            'required' => false,
            'label' => 'Hotel Vacancy (optional)'
        ))
        ->add('imageFile', Type\FileType::class, array(
            'required' => false,
            'label' => 'Hotel Photo (optional)'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('Hotel'),
            'data_class' => 'AppBundle\Entity\Hotel',
        ));
    }

}
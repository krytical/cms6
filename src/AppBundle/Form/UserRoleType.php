<?php
/**
 * Created by PhpStorm.
 * User: montse
 * Date: 2016-03-09
 * Time: 12:29 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserRoleType extends AbstractType
{
    // Form for editing security roles for one user
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', Type\TextareaType::class);

        $builder->add('roles', CollectionType::class, array(
            'entry_type'   => ChoiceType::class,
            'entry_options'  => array(
                'choices'  => array(
                    'nashville' => 'Nashville',
                    'paris'     => 'Paris',
                    'berlin'    => 'Berlin',
                    'london'    => 'London',
                ),
            ),
        ));


        /*

        $builder->add('roles', CollectionType::class, array(

            'entry_type'   => CheckboxType::class,

            'entry_options'  => array(
                'required'  => false,
            ),
        ));*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('User'),
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
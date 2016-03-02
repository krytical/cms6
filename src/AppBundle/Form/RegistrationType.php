<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('phone');
        $builder->add('imageFile', Type\FileType::class);
        $builder->add('approved', Type\HiddenType::class, array(
            'data' => 'false'
        ));
    }

    # TODO: Add this in to get our user validation working

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'validation_groups' => array('User'),
//            'data_class' => 'AppBundle\Entity\User',
//
//            # TODO: figure out if we need these (copied from RegistrationFormType.php)
//            //'data_class' => $this->class,
//            //'csrf_token_id' => 'registration',
//            //    // BC for SF < 2.8
//            //'intention'  => 'registration',
//        ));
//    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
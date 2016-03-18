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
        $builder->add('firstName')
        ->add('lastName')
        ->add('phone', Type\TextType::class, array(
            'required' => false,
            'label' => 'Phone Number (optional)'
        ))
        ->add('imageFile', Type\FileType::class, array(
            'required' => false,
            'label' => 'Profile Picture (optional)'
        ))
        ->add('approved', Type\HiddenType::class, array(
            'data' => 'false'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('User'),
            'data_class' => 'AppBundle\Entity\User',
            //'csrf_token_id' => 'registration',
        ));
    }

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
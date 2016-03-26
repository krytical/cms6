<?php
/**
 * Created by PhpStorm.
 * User: montse
 * Date: 2016-03-16
 * Time: 3:23 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SecurityRoleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // TODO: change name of class from security role to user role
        // TODO: add enabled field to user role
        $builder->add('name');
        $builder->add('enabled', CheckboxType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Resources\HelperClasses\UserRole',
        ));
    }

}
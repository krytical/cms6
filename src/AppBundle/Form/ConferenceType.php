<?php


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        # TODO: Passing type instances to FormBuilder::add(), Form::add() or the
        # FormFactory is deprecated since version 2.8 and will not be supported
        # in 3.0. Use the fully-qualified type class name instead

        # TODO: add description and change startDate and endDate to startDatetime endDatetime
        $builder->add('name');
        $builder->add('location');
        $builder->add('startDate');
        $builder->add('endDate');
        $builder->add('imgName');
    }

}
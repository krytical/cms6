<?php

namespace AppBundle\Resources\HelperClasses;


class UserRole
{

    private $name;

    private $enabled;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function isEnabled(){
        return $this->enabled;
    }

    public function setEnabled($enable){
        $this->enabled = $enable;
    }



}

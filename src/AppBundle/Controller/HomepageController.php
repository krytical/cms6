<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        # TODO: Display a list of conferences

        $numbers = array();
        for ($i = 0; $i < 5; $i++) {
            $numbers[] = rand(0, 100);
        }
        $numbersList = implode(', ', $numbers);

        // renders the homepage
        return $this->render(
            'homepage/homepage.html.twig',
            array('luckyNumber' => $numbersList)
        );
    }
}

<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        # This is just a stub to show how controllers work.
        # Change this to properly display the homepage

        $numbers = array();
        for ($i = 0; $i < 5; $i++) {
            $numbers[] = rand(0, 100);
        }
        $numbersList = implode(', ', $numbers);

        // renders the homepage
        return $this->render(
            'homepage/index.html.twig',
            array('luckyNumber' => $numbersList)
        );
    }

    # EVAN NOTES FOR LATER (http://symfony.com/doc/2.8/book/controller.html)
    # remember to specify route by GET, HEAD, PUT....

    # if PUT route:
    # use Symfony\Component\HttpFoundation\Request;
    # public function xAction(Request $request)
}

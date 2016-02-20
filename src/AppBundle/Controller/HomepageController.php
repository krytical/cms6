<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;

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


        $conference = new Conference();
        $form = $this->createForm(new ConferenceType(), $conference);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // if its a valid confernece need to add it to the database and put it on homw page
                 return $this->redirect($this->generateUrl('_welcome'));
            }

        }

        // renders the homepage
        return $this->render(
            'homepage/index.html.twig',
            array('luckyNumber' => $numbersList,
                'form' => $form->createView())
        );
    }


    # EVAN NOTES FOR LATER (http://symfony.com/doc/2.8/book/controller.html)
    # remember to specify route by GET, HEAD, PUT....

    # if PUT route:
    # use Symfony\Component\HttpFoundation\Request;
    # public function xAction(Request $request)
}

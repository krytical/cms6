<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;

class ConferenceController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function conferenceAction(Request $request)
    {

// 1) build the form
        $conference = new Conference();
        $form = $this->createForm(new ConferenceType(), $conference);
// 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // if its a valid conference need to add it to the database and put it on homepage
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            return $this->redirect($this->generateUrl('_welcome'));

        }

        // renders the homepage
        return $this->render(
            'conference/conference.html.twig',
            array(
                'form' => $form->createView())
        );
    }
}
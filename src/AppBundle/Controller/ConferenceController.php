<?php

// src/AppBundle/Controller/ConferenceController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;

class ConferenceController extends Controller
{
    /**
     * @Route("/conference", name="conference")
     */
    public function conferenceAction(Request $request)
    {

        # TODO: THIS IS BROKEN

        // 1) build the form
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // if its a valid conference need to add it to the database and put it on homepage
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            $this->addFlash(
                'notice',
                'Conference created successfully!'
            );

            return $this->redirectToRoute('_welcome');

        }

        // renders the homepage
        return $this->render(
            'conference/conference.html.twig',
            array(
                'form' => $form->createView())
        );
    }

    /**
     * @Route("/conference/{conf_id}", name="conference_show")
     */
    public function showAction($conf_id)
    {
        # TODO: stub for showing a conference (this can contain all the events if we want)

        # render the show page for the conference
        return $this->render(
            'conference/conference_show.html.twig', array(
            'conf_id' => $conf_id,
        ));
    }

    /**
     * @Route("/conference/{conf_id}/edit", name="conference_edit")
     */
    public function editAction(Request $request, $conf_id)
    {
        # TODO: stub for editing a conference (can add, remove events also)

        # render the edit page for the conference
        return $this->render(
            'conference/conference_edit.html.twig', array(
            'conf_id' => $conf_id,
        ));
    }
}
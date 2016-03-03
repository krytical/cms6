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

        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            $this->addFlash(
                'notice',
                'Conference created successfully!'
            );

            return $this->redirectToRoute('_welcome');
        }

        // renders the main conference page
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
        # TODO: stub for showing a conference
        # (not totally necessary but would be nice)
        # (this can contain all the events if we want)

        # render the show page for the conference
		$conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);
		
        return $this->render(
            'conference/conference_show.html.twig', array(
            'conf_id' => $conference,
        ));
    }

    /**
     * @Route("/conference/{conf_id}/edit", name="conference_edit")
     */
    public function editAction(Request $request, $conf_id)
    {
        # TODO: add the ability to add/remove events

        $conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);

        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            $this->addFlash(
                'notice',
                'Conference edited successfully!'
            );

            return $this->redirectToRoute('conference');
        }

        # render the edit page for the conference
        return $this->render(
            'conference/conference_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
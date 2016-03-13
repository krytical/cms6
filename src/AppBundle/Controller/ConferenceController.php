<?php

// src/AppBundle/Controller/ConferenceController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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
        # TODO: We may want to change this route to /conference/create
        # and have /conference render the homepage

        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            $this->addFlash(
                'success',
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
        # TODO: get all events for the conference and pass them to the view

        # render the show page for the conference
		$conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);

        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException('This conference does not exist.');
        }
		
		$confevents = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->findBy(array('conference' => $conference->getId()), array('id' => 'DESC'));

        return $this->render(
            'conference/conference_show.html.twig', array(
            'conf_id' => $conference,
			'conf_events' => $confevents
        ));
    }

    /**
     * @Route("/conference/{conf_id}/edit", name="conference_edit")
     */
    public function editAction(Request $request, $conf_id)
    {

        $conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);

        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException('The conference you are trying to edit does not exist.');
        }

        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference);
            $em->flush();

            $this->addFlash(
                'success',
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

    /**
     * @Route("/conference/{conf_id}/delete", name="conference_delete")
     */
    public function deleteAction($conf_id)
    {
        $conference = $this->getDoctrine()
        ->getRepository('AppBundle:Conference')
        ->find($conf_id);

        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException('The conference you are trying to delete does not exist.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($conference);
        $em->flush();

        $this->addFlash(
            'success',
            'Conference deleted successfully!'
        );

        # calls the homepage controller to render the homepage
        return $this->forward('AppBundle:Homepage:homepage');
    }
}
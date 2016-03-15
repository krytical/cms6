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
     * @Route("/conference/create", name="conference")
     *
     * @param Request $request
     *  The submitted ConferenceType form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        # TODO: check user privileges
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

            # TODO: render admin conference page
            return $this->redirectToRoute('_welcome');
        }

        // renders the conference creation page
        return $this->render(
            'conference/conference_create.html.twig',
            array(
                'form' => $form->createView())
        );
    }

    /**
     * @Route("/conference/{conf_id}", name="conference_show")
     *
     * @param string $conf_id
     *  The id of the conference to be displayed
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($conf_id)
    {
        // get the conference
		$conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException('This conference does not exist.');
        }

        // get the conference events
		$confevents = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->findBy(array('conference' => $conference->getId()), array('id' => 'DESC'));

        // render the conference page
        return $this->render(
            'conference/conference_show.html.twig', array(
            'conf_id' => $conference,
			'conf_events' => $confevents
        ));
    }

    /**
     * @Route("/conference/{conf_id}/edit", name="conference_edit")
     *
     * @param Request $request
     *  The submitted ConferenceType form
     * @param string $conf_id
     *  The id of the conference to be edited
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $conf_id)
    {
        # TODO: check user privileges
        // get the conference
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

            # TODO: render admin conference page
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
     *
     * @param string $conf_id
     *  The id of the conference to be deleted
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($conf_id)
    {
        # TODO: check user privileges
        // get the conference
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

        # TODO: render admin conference page
        return $this->forward('AppBundle:Homepage:homepage');
    }
}
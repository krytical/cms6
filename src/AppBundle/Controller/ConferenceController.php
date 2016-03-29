<?php

// src/AppBundle/Controller/ConferenceController.php
namespace AppBundle\Controller;

use AppBundle\Entity\ConferenceRegistration;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ConferenceController extends Controller
{
    /**
     * @Route("/conference/create", name="conference")
     * @Security("has_role('ROLE_CONFERENCE_MANAGER')")
     *
     * @param Request $request
     *  The submitted ConferenceType form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($conference);

            $this->addFlash(
                'success',
                'Conference created successfully!'
            );

            return $this->redirectToRoute('conference_show_all');
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
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference
        $conference = $helper->getConference($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException("The conference with ID {$conf_id} does not exist.");
        }

        // get the conference events
		$conf_events = $helper->getConferenceEvents($conference->getId());

        // get the user
        $user = $this->getUser();
        $conf_reg = null;
        $event_regs = array();
        if (is_object($user) && $user instanceof UserInterface) {

            // check if the user is registered for the conference
            $conf_reg = $helper->getUsersConferenceRegistration($user->getId(), $conference->getId());
            if (is_object($conf_reg) && $conf_reg instanceof ConferenceRegistration){

                // get all the event registrations for that conference registration
                $event_regs = $helper->getEventRegistrationByConfReg($conf_reg->getId());
            }
        }

        // render the conference page
        return $this->render(
            'conference/conference_show.html.twig', array(
            'conf_id' => $conference,
			'conf_events' => $conf_events,
            'conf_reg' => $conf_reg,
            'event_regs' => $event_regs
        ));
    }

    /**
     * @Route("/conference/{conf_id}/edit", name="conference_edit")
     * @Security("has_role('ROLE_CONFERENCE_MANAGER')")
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
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference
        $conference = $helper->getConference($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException(
                "The conference with ID {$conf_id} that you are trying to edit does not exist.");
        }

        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($conference);

            $this->addFlash(
                'success',
                'Conference edited successfully!'
            );

            return $this->redirectToRoute('conference_show_all');
        }

        # render the edit page for the conference
        return $this->render(
            'conference/conference_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference/{conf_id}/delete", name="conference_delete")
     * @Security("has_role('ROLE_CONFERENCE_MANAGER')")
     *
     * @param string $conf_id
     *  The id of the conference to be deleted
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($conf_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference
        $conference = $helper->getConference($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException(
                "The conference with ID {$conf_id} that you are trying to delete does not exist.");
        }

        $helper->deleteEntity($conference);

        $this->addFlash(
            'success',
            'Conference deleted successfully!'
        );

        return $this->redirectToRoute('conference_show_all');
    }
}
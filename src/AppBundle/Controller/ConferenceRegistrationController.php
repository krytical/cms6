<?php

// src/AppBundle/Controller/ConferenceRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\Conference;
use AppBundle\Entity\ConferenceRegistration;
use AppBundle\Entity\User;

use AppBundle\Form\ConferenceRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ConferenceRegistrationController extends Controller
{
    /**
     * @Route("/conference_registration", name="conf_reg_show_all")
     * @Security("has_role('ROLE_CONFERENCE_MANAGER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAllAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get all the conferences
        $conferences = $helper->getAllConferences();

        // get all the events
        $events = $helper->getAllEvents();

        // get all the conference registrations
        $conferenceRegistrations = $helper->getAllConferenceRegistrations();

        // get all the event registrations
        $eventRegistrations = $helper->getAllEventRegistrations();

        // render the show all conference registrations page
        return $this->render('conferenceRegistration/conference_reg_show_all.html.twig', array(
            'conferences' => $conferences,
            'events' => $events,
            'conf_regs' => $conferenceRegistrations,
            'event_regs' => $eventRegistrations
        ));
    }
	
	/**
     * @Route("/conference/{conf_id}/registration", name="conference_attendance")
     * @Security("has_role('ROLE_CONFERENCE_MANAGER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
	public function showAttendanceListAction($conf_id)
	{
		// get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference
        $conference = $helper->getConference($conf_id);
		
		// get all the conference registrations for that conference
        $conferenceRegistrations = $helper->getAllConferenceRegistrations($conference->getID());
		
		return $this->render('conference/conference_attendance.html.twig', array(
            'conference' => $conference,
            'conf_regs' => $conferenceRegistrations,
        ));
	}

    /**
     * @Route("/conference/{conf_id}/register", name="conf_reg_create")
     *
     * @param Request $request
     *  The submitted ConferenceRegistrationType form
     * @param string $conf_id
     *  The id of the conference to register for
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $conf_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference
        $conference = $helper->getConference($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
             $this->addFlash(
                'danger',
                "The conference  with ID {$conf_id} that you are trying to register for does not exist"
            );

            // go to profile page
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException(
                'Please log in to register for a conference.');
        }

        // Check if the user already registered for the conference
        $registration = $helper->getUsersConferenceRegistration($user->getId(), $conference->getId());
        if (is_object($registration) && $registration instanceof ConferenceRegistration){
            $this->addFlash(
                'danger',
                'You are already registered to this conference, please check your profile!'
            );

            // go to profile page
            return $this->redirectToRoute('fos_user_profile_show');
        }

        $conference_reg = new ConferenceRegistration();
        $form = $this->createForm(ConferenceRegistrationType::class, $conference_reg);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            // (we don't setHotelRegistration since that is done by the hotel manager)
            $conference_reg->setUser($user);
            $conference_reg->setConference($conference);

            $helper->setEntity($conference_reg);
			
            $this->addFlash(
                'success',
                'Successfully registered for conference!'
            );

            // renders the conference page
            return $this->redirectToRoute('conference_show', ['conf_id' => $conf_id]);
        }

        // renders the register for conference page
        return $this->render(
            'conferenceRegistration/conference_reg_create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}", name="conf_reg_show")
     *
     * @param $conf_reg_id
     *  The ID of the conference registration to show
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference registration
        $confReg = $helper->getConferenceRegistration($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (ID: {$conf_reg_id}) does not exist.");
        }

        // check user privileges
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BOOKINGS_MANAGER') && $confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot view the registration of another user.');
        }

        // TODO: get the hotel registration

        // render the conference registration page
        return $this->render('conferenceRegistration/conference_reg_show.html.twig', array(
            'conf_reg'=>$confReg,
        ));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/approve", name="conf_reg_approve")
     *
     * @param $conf_reg_id
     *  The ID of the conference registration to be approved
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approveAction($conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $conf_reg = $helper->getConferenceRegistration($conf_reg_id);
        $conf_reg->setApproved(true);

        $helper->setEntity($conf_reg);

        // render the conference attendance page
        return $this->redirectToRoute('conference_attendance', array('conf_id' => $conf_reg->getConference()->getID()));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/disapprove", name="conf_reg_disapprove")
     *
     * @param $conf_reg_id
     *  The ID of the conference registration to be disapproved
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disapproveAction($conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $conf_reg = $helper->getConferenceRegistration($conf_reg_id);
        $conf_reg->setApproved(false);

        $helper->setEntity($conf_reg);

        // render the conference attendance page
        return $this->redirectToRoute('conference_attendance', array('conf_id' => $conf_reg->getConference()->getID()));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/edit", name="conf_reg_edit")
     *
     * @param Request $request
     *  The submitted ConferenceRegistrationType form
     * @param string $conf_reg_id
     *  The id of the conference registration to edit
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the registration
        $confReg = $helper->getConferenceRegistration($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (with ID {$conf_reg_id}) you are trying to edit does not exist.");
        }

        // check user privileges
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BOOKINGS_MANAGER') && $confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot edit the Registration of another user.');
        }

        $form = $this->createForm(ConferenceRegistrationType::class, $confReg);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($confReg);

            $this->addFlash(
                'success',
                'Conference Registration edited successfully!'
            );

            // render the profile
            return $this->redirectToRoute('fos_user_profile_show');
        }

        // render the edit page for the conference
        return $this->render(
            'conferenceRegistration/conference_reg_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/delete", name="conf_reg_delete")
     *
     * @param $conf_reg_id
     *  The id of the conference registration to delete
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the registration
        $confReg = $helper->getConferenceRegistration($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (with ID: {$conf_reg_id}) you are trying to delete does not exist.");
        }

        // check user privileges
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BOOKINGS_MANAGER') && $confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot delete the Registration of another user.');
        }

        $helper->deleteEntity($confReg);

        $this->addFlash(
            'success',
            'Conference registration deleted successfully!'
        );

        if ($this->get('security.authorization_checker')->isGranted('ROLE_BOOKINGS_MANAGER')){
            // render the conference attendance page
            return $this->redirectToRoute('conference_attendance', array('conf_id' => $confReg->getConference()->getID()));
        }
        else{
            // renders the profile
            return $this->redirectToRoute('fos_user_profile_show');
        }
    }
}
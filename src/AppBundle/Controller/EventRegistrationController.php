<?php

// src/AppBundle/Controller/EventRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\EventRegistration;
use AppBundle\Entity\Conference;
use AppBundle\Entity\ConferenceRegistration;
use AppBundle\Entity\User;
use AppBundle\Entity\Event;

use AppBundle\Form\EventRegistrationType;


class EventRegistrationController extends Controller
{
    /**
     * @Route("/event/{conf_id}/event/{event_id}/register", name="event_reg_create")
     */
      # TODO: stub for main ER page in case we want to do something with all ERs
        # (probably don't need this since we're having a single page for the registration manager)
    public function createAction(Request $request, $conf_id, $event_id)
    {
         $event = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->find($event_id);

        $conference = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);


         if (!is_object($event) || !$event 
            instanceof Event) {
            throw $this->createNotFoundException('This event you are trying to register for does not exist.');
        }

        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException(
                'Please log in to register for the event.');
        }

        // Check if the user is registered for the conference
        $registration = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findOneBy(array('user' => $user->getId(), 'conference' => $conference->getId()));
        if (!is_object($registration) && !$registration instanceof ConferenceRegistration){
            throw new AccessDeniedException(
                'You are not registered for the conference of this event and so you cannot register for this event. Please register for the conference and then try again');
        }

        // Check if the user already registered for the event
        $check = $this->getDoctrine()
            ->getRepository('AppBundle:EventRegistration')
            ->findOneBy(array('user' => $user->getId(), 'event' => $event->getId()));
        if (is_object($check) && $check instanceof EventRegistration){
            throw new AccessDeniedException(
                'You are already registered for this Event. If you would like to edit your registration, go to your profile.');
        }

        // set data for table
        $event_reg = new EventRegistration();
        $event_reg-> setUser($user);
        $event_reg-> setEvent($event);
        $event_reg-> setGuests("1");
        $event_reg-> setApproved("y");

        
        //put it in the database
        $em = $this->getDoctrine()->getManager();

        $em->persist($event_reg);
    	$em->flush();

    	$this->addFlash(
                'success',
                'Successfully registered for event!'
        );


        // renders the main event page
        return $this->render(
            'eventRegistration/event_reg_create.html.twig'
        );
    }

    /**
     * @Route("/profile/event_registration", name="user_event_reg_show")
     */
    public function showUserEventRegistrationsAction()
    {
        # TODO: stub for showing all the ERs of a user
        # (probably don't need this since we're showing it on the profile instead)

        # render the show page for the ERs of the user
        return $this->render(
            'Profile/event_registrations_show.html.twig'
        );
    }

    /**
     * @Route("/profile/event_registration/{event_reg_id}/edit", name="event_reg_edit")
     */
    public function editAction(Request $request, $event_reg_id)
    {
        # TODO: stub for editing an ER

         $eventReg = $this->getDoctrine()
            ->getRepository('AppBundle:EventRegistration')
            ->find($event_reg_id);

        if (!is_object($eventReg) || !$eventReg instanceof EventRegistration) {
            throw $this->createNotFoundException('The event registration you are trying to edit does not exist.');
        }

         elseif ($eventReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot edit the Registration of another user.');
        }

        $form = $this->createForm(EventRegistrationType::class, $eventReg);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventReg);
            $em->flush();

            $this->addFlash(
                'success',
                'Event Registration edited successfully!'
            );

            return $this->redirectToRoute('fos_user_profile_show');
        }


        # render the edit page for the event
        return $this->render(
            'Profile/event_registration_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/profile/conference_registration/{event_reg_id}/delete", name="event_reg_delete")
     */
    public function deleteAction($event_reg_id)
    {
         $eventReg = $this->getDoctrine()
            ->getRepository('AppBundle:EventRegistration')
            ->find($event_reg_id);

         if (!is_object($eventReg) || !$eventReg instanceof EventRegistration) {
            throw $this->createNotFoundException('The event registration you are trying to delete does not exist.');
        }
        elseif ($eventReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot delete the Registration of another user.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($eventReg);
        $em->flush();

         $this->addFlash(
            'success',
            'Event registration deleted successfully!'
        );

    	// renders the profile
        return $this->redirectToRoute('fos_user_profile_show');
    }
}
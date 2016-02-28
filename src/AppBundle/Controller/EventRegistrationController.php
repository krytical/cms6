<?php

// src/AppBundle/Controller/EventRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EventRegistration;

class EventRegistrationController extends Controller
{
    /**
     * @Route("/event_registration", name="event_registration")
     */
    public function eventRegistrationAction()
    {
        # TODO: stub for main ER page in case we want to do something with all ERs
        # (we may just want to have a single super admin page that has all this)

        // renders the main event page
        return $this->render(
            'eventRegistration/event_registration.html.twig'
        );
    }

    /**
     * @Route("/profile/event_registration", name="user_event_reg_show")
     */
    public function showUserEventRegistrationsAction()
    {
        # TODO: stub for showing all the ERs of a user (we probably want to
        # just show all registration info all together on the regular profile instead)

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

        # render the edit page for the event
        return $this->render(
            'Profile/event_registration_edit.html.twig', array(
            'event_reg_id' => $event_reg_id,
        ));
    }
}
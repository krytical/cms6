<?php

// src/AppBundle/Controller/ConferenceRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ConferenceRegistration;

class ConferenceRegistrationController extends Controller
{
    /**
     * @Route("/conference_registration", name="conference_registration")
     */
    public function conferenceRegistrationAction()
    {
        # TODO: stub for main CR page in case we want to do something with all CRs
        # (probably don't need this since we're going to have a single registration manager page)

        // renders the main event page
        return $this->render(
            'conferenceRegistration/conference_registration.html.twig'
        );
    }

    /**
     * @Route("/profile/conference_registration", name="user_conf_reg_show")
     */
    public function showUserConferenceRegistrationsAction()
    {
        # TODO: stub for showing all the CRs of a user
        # (probably don't need this since we're showing the user registrations on the profile)

        # render the show page for the CRs of the user
        return $this->render(
            'Profile/conference_registrations_show.html.twig'
        );
    }

    /**
     * @Route("/profile/conference_registration/{conf_reg_id}/edit", name="conf_reg_edit")
     */
    public function editAction(Request $request, $conf_reg_id)
    {
        # TODO: stub for editing a CR

        # render the edit page for the conference
        return $this->render(
            'Profile/conference_registration_edit.html.twig', array(
            'conf_reg_id' => $conf_reg_id,
        ));
    }
}
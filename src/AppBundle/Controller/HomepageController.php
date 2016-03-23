<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the user
        $user = $this->getUser();

        // get all the conferences
        $conferences = $helper->getAllConferences();

		// get all the conference_id to event mappings
        $eventsMap = $helper->conferenceEventMap($conferences);

        // get all of the conference registrations for the user
        $conferenceRegs = $helper->getAllUsersConferenceRegistrations($user->getID());

        // get all the conference_registration_id to event registration mappings for the user
        $eventRegMap = $helper->conferenceRegEventRegMap($conferenceRegs);

        return $this->render('homepage/homepage.html.twig', array(
            'conferences' => $conferences,
            'events' => $eventsMap,
            'conference_regs' => $conferenceRegs,
            'event_regs' => $eventRegMap
        ));
    }
}

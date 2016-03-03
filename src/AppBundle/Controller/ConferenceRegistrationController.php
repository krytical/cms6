<?php

// src/AppBundle/Controller/ConferenceRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ConferenceRegistration;
use AppBundle\Form\ConferenceRegistrationType;

class ConferenceRegistrationController extends Controller
{
    /**
     * @Route("/conference/{conf_id}/register", name="conference_reg")
     */
    public function conferenceRegistrationAction(Request $request, $conf_id)
    {

        // submit the registration
        $conference_reg = new ConferenceRegistration();
        $form = $this->createForm(ConferenceRegistrationType::class, $conference_reg);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            // (we don't setHotelRegistration since that is done by the hotel manager)
            $conference_reg->setUser($this->getUser());

            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Conference');
            $conference = $repository->find($conf_id);
            $conference_reg->setConference($conference);

            // persist the registration to the DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference_reg);
            $em->flush();

            $this->addFlash(
                'notice',
                'Successfully registered for conference!'
            );

            return $this->redirectToRoute('conference');
        }

        // renders the main conference registration page
        return $this->render(
            'conferenceRegistration/conference_reg.html.twig', array(
            'form' => $form->createView()
        ));
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
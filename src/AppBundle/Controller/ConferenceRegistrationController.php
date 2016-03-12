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

class ConferenceRegistrationController extends Controller
{
    /**
     * @Route("/conference/{conf_id}/register", name="conference_reg")
     */
    public function conferenceRegistrationAction(Request $request, $conf_id)
    {

        // get the conference
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Conference');
        $conference = $repository->find($conf_id);
        if (!is_object($conference) || !$conference instanceof Conference) {
            throw $this->createNotFoundException('The conference you are trying to register for does not exist.');
        }

        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException(
                'Please log in to register for a conference.');
        }

        // Check if the user already registered for the conference
        $registration = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findOneBy(array('user' => $user->getId(), 'conference' => $conference->getId()));
        if (is_object($registration) && $registration instanceof ConferenceRegistration){
            throw new AccessDeniedException(
                'You are already registered for this conference. If you would like to edit your registration, go to your profile.');
        }

        // submit the registration
        $conference_reg = new ConferenceRegistration();
        $form = $this->createForm(ConferenceRegistrationType::class, $conference_reg);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            // (we don't setHotelRegistration since that is done by the hotel manager)
            $conference_reg->setUser($user);
            $conference_reg->setConference($conference);

            // persist the registration to the DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($conference_reg);
            $em->flush();
			
            $this->addFlash(
                'success',
                'Successfully registered for conference!'
            );

            return $this->redirectToRoute('conference_show', ['conf_id' => $conf_id]);
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
            'conferenceRegistration/conference_registrations_show.html.twig'
        );
    }

    /**
     * @Route("/profile/conference_registration/{conf_reg_id}/edit", name="conf_reg_edit")
     */
    public function editAction(Request $request, $conf_reg_id)
    {
        $confReg = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);

        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException('The conference registration you are trying to edit does not exist.');
        }
        elseif ($confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot edit the Registration of another user.');
        }

        $form = $this->createForm(ConferenceRegistrationType::class, $confReg);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($confReg);
            $em->flush();

            $this->addFlash(
                'success',
                'Conference Registration edited successfully!'
            );

            return $this->redirectToRoute('fos_user_profile_show');
        }

        # render the edit page for the conference
        return $this->render(
            'conferenceRegistration/conference_reg_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/profile/conference_registration/{conf_reg_id}/delete", name="conf_reg_delete")
     */
    public function deleteAction($conf_reg_id)
    {
        $confReg = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);

        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException('The conference registration you are trying to delete does not exist.');
        }
        elseif ($confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot delete the Registration of another user.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($confReg);
        $em->flush();

        $this->addFlash(
            'success',
            'Conference registration deleted successfully!'
        );

        # calls the homepage controller to render the homepage
        return $this->forward('AppBundle:Homepage:homepage');
    }
}
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
     * @Route("/conference_registration", name="conf_reg_show_all")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAllAction()
    {
        # TODO: check user privileges
        // get the conference registrations
        $conferenceRegistrations = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findAll();

        // render the show all conference registrations page
        return $this->render('conferenceRegistration/conference_reg_show_all.html.twig', array(
            'conf_regs'=>$conferenceRegistrations,
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

        $conference_reg = new ConferenceRegistration();
        $form = $this->createForm(ConferenceRegistrationType::class, $conference_reg);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            // (we don't setHotelRegistration since that is done by the hotel manager)
            $conference_reg->setUser($user);
            $conference_reg->setConference($conference);

            $em = $this->getDoctrine()->getManager();
            $em->persist($conference_reg);
            $em->flush();
			
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
        # TODO: check user privileges
        // get the conference registration
        $confReg = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (ID: {$conf_reg_id}) does not exist.");
        }
        elseif ($confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot view the registration of another user.');
        }

        // render the conference registration page
        return $this->render('conferenceRegistration/conference_reg_show.html.twig', array(
            'conf_reg'=>$confReg,
        ));
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
        // get the registration
        $confReg = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (with ID {$conf_reg_id}) you are trying to edit does not exist.");
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
        // get the registration
        $confReg = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (with ID: {$conf_reg_id}) you are trying to delete does not exist.");
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

        // renders the profile
        return $this->redirectToRoute('fos_user_profile_show');
    }
}
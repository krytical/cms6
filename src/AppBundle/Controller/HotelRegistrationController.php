<?php

// src/AppBundle/Controller/HotelRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\ConferenceRegistration;
use AppBundle\Entity\HotelRegistration;
use AppBundle\Form\HotelRegistrationType;

class HotelRegistrationController extends Controller
{
    /**
     * @Route("/conference_registration/{conf_reg_id}/hotel_registration/create", name="hotel_reg_create")
     *
     * @param Request $request
     *  The submitted HotelRegistrationType form
     * @param $conf_reg_id
     *  The id of the conference registration to assign a hotel to
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, $conf_reg_id)
    {
        # TODO: check user privileges
        // get the conference registration
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration');
        $conferenceRegistration = $repository->find($conf_reg_id);
        if (!is_object($conferenceRegistration) || !$conferenceRegistration instanceof ConferenceRegistration) {
            throw $this->createNotFoundException('The conference registration you are trying to assign a hotel to does not exist.');
        }

        // Check if the conference registration already has a hotel registration
        $hotelRegistration = $this->getDoctrine()
            ->getRepository('AppBundle:HotelRegistration')
            ->findOneBy(array('conferenceRegistration' => $conferenceRegistration->getId()));
        if (is_object($hotelRegistration) && $hotelRegistration instanceof HotelRegistration){
            throw new AccessDeniedException(
                "The conference registration (ID: {$conf_reg_id}) already has a hotel registration (ID: {$hotelRegistration->getId()}). Try editing the registration or delete it and create a new one."
            );
        }

        $hotelRegistration = new HotelRegistration();
        $form = $this->createForm(HotelRegistrationType::class, $hotelRegistration);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            $hotelRegistration->setConferenceRegistration($conferenceRegistration);

            $em = $this->getDoctrine()->getManager();
            $em->persist($hotelRegistration);
            $em->flush();

            $this->addFlash(
                'success',
                'Successfully registered for hotel!'
            );

            // renders the conference registration page
            return $this->redirectToRoute('conf_reg_show', ['conf_reg_id' => $conf_reg_id]);
        }

        // renders the main hotel registration page
        return $this->render(
            'hotelRegistration/hotel_reg_create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/hotel_registration", name="conf_reg_show")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($conf_reg_id)
    {
        #TODO: this
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/hotel_registration/edit", name="hotel_reg_edit")
     *
     * @param Request $request
     *  The submitted HotelRegistrationType form
     * @param $conf_reg_id
     *  The id of the conference registration to assign a hotel to
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $conf_reg_id)
    {
        # TODO: check use privilege
        // get the registration
        $hotelReg = $this->getDoctrine()
            ->getRepository('AppBundle:HotelRegistration')
            ->findOneBy(array('conferenceRegistration' => $conf_reg_id));
        if (!is_object($hotelReg) || !$hotelReg instanceof HotelRegistration) {
            throw $this->createNotFoundException("The hotel registration you are trying to edit does not exist.");
        }

        $form = $this->createForm(HotelRegistrationType::class, $hotelReg);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotelReg);
            $em->flush();

            $this->addFlash(
                'success',
                'Hotel Registration edited successfully!'
            );

            // render the hotel registration
            return $this->redirectToRoute('hotel_reg_show', ['conf_reg_id' => $conf_reg_id]);
        }

        // render the edit page for the hotel registration
        return $this->render(
            'hotelRegistration/hotel_reg_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference_registration/{conf_reg_id}/hotel_registration/delete", name="hotel_reg_delete")
     *
     * @param $conf_reg_id
     *  The id of the conference registration to remove a hotel from
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($conf_reg_id)
    {
        # TODO: check use privilege
        // get the registration
        $hotelReg = $this->getDoctrine()
            ->getRepository('AppBundle:HotelRegistration')
            ->findOneBy(array('conferenceRegistration' => $conf_reg_id));
        if (!is_object($hotelReg) || !$hotelReg instanceof HotelRegistration) {
            throw $this->createNotFoundException("The hotel registration you are trying to edit does not exist.");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($hotelReg);
        $em->flush();

        $this->addFlash(
            'success',
            'Hotel registration deleted successfully!'
        );

        // renders the conference registration page
        return $this->redirectToRoute('conf_reg_show', ['conf_reg_id' => $conf_reg_id]);
    }
}
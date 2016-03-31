<?php

// src/AppBundle/Controller/HotelRegistrationController.php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
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
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the conference registration
        $conferenceRegistration = $helper->getConferenceRegistration($conf_reg_id);
        if (!is_object($conferenceRegistration) || !$conferenceRegistration instanceof ConferenceRegistration) {
           $this->addFlash(
                'danger',
                'The conference registration you are trying to assign a hotel to does not exist.');

           // go back
            return $this->redirectToRoute('hotel_reg_create');

        }

        // Check if the conference registration already has a hotel registration
        $hotelRegistration = $helper->getHotelRegistration($conf_reg_id);
        if (is_object($hotelRegistration) && $hotelRegistration instanceof HotelRegistration){
            $this->addFlash(
                'danger',
                "The conference registration (ID: {$conf_reg_id}) already has a hotel registration (ID: {$hotelRegistration->getId()}). Try editing the registration or delete it and create a new one."
            );

            // go back
            return $this->redirectToRoute('hotel_reg_create');

        }

        $hotelRegistration = new HotelRegistration();
        $form = $this->createForm(HotelRegistrationType::class, $hotelRegistration);
        $form->handleRequest($request);

        if ($form->isValid()) {

            // add the foreign keys now
            $hotelRegistration->setConferenceRegistration($conferenceRegistration);

            $helper->setEntity($hotelRegistration);

            // send a notification e-mail to the user if they have an e-mail set.
            $user = $conferenceRegistration->getUser();
            if (is_object($user) && $user instanceof UserInterface && !empty($user->getEmail())) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('CMS Hotel Registration')
                    ->setFrom($this->getParameter('contact_email'))
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/hotel_registration.html.twig', array(
                                'name' => $user->getFirstName())
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);

                $this->addFlash(
                    'success',
                    'Hotel registration created successfully! An email has been sent to the user!'
                );
            }
            else {
                $this->addFlash(
                    'success',
                    'Hotel registration created successfully! No notification sent (User is not registered with an e-mail).'
                );
            }

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
     * @param $conf_reg_id
     *  The ID of the conference for which to display hotel information
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($conf_reg_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel registration
        $hotelReg = $helper->getHotelRegistration($conf_reg_id);
        if (!is_object($hotelReg) || !$hotelReg instanceof HotelRegistration) {
            throw $this->createNotFoundException("The hotel registration to display does not exist.");
        }

        // get the conference registration so we can check the user
        $confReg = $helper->getConferenceRegistration($conf_reg_id);
        if (!is_object($confReg) || !$confReg instanceof ConferenceRegistration) {
            throw $this->createNotFoundException("The conference registration (ID: {$conf_reg_id}) does not exist.");
        }
        elseif ($confReg->getUser() != $this->getUser()) {
            throw new AccessDeniedException('You cannot view the registration of another user.');
        }

        // render the hotel registration page
        return $this->render('hotelRegistration/hotel_reg_show.html.twig', array(
            'hotel' => $hotelReg->getHotel(),
            'hotel_reg' => $hotelReg
        ));
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
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel registration
        $hotelReg = $helper->getHotelRegistration($conf_reg_id);
        if (!is_object($hotelReg) || !$hotelReg instanceof HotelRegistration) {
            throw $this->createNotFoundException("The hotel registration you are trying to edit does not exist.");
        }

        $form = $this->createForm(HotelRegistrationType::class, $hotelReg);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($hotelReg);

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
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel registration
        $hotelReg = $helper->getHotelRegistration($conf_reg_id);
        if (!is_object($hotelReg) || !$hotelReg instanceof HotelRegistration) {
            throw $this->createNotFoundException("The hotel registration you are trying to delete does not exist.");
        }

        $helper->deleteEntity($hotelReg);

        $this->addFlash(
            'success',
            'Hotel registration deleted successfully!'
        );

        // renders the conference registration page
        return $this->redirectToRoute('conf_reg_show', ['conf_reg_id' => $conf_reg_id]);
    }
}
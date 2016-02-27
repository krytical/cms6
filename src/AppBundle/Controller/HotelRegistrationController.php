<?php

// src/AppBundle/Controller/HotelRegistrationController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\HotelRegistration;

class HotelRegistrationController extends Controller
{
    /**
     * @Route("/hotel_registration", name="hotel_registration")
     */
    public function hotelRegistrationAction()
    {
        # TODO: stub for main HR page in case we want to do something with all HRs
        # (we may just want to have a single super admin page that has all this)

        // renders the main hotel page
        return $this->render(
            'hotelRegistration/hotel_registration.html.twig'
        );
    }

    /**
     * @Route("/profile/hotel_registration", name="user_hotel_reg_show")
     */
    public function showUserHotelRegistrationsAction()
    {
        # TODO: stub for showing all the HRs of a user (we probably want to
        # just show all registration info all together on the regular profile instead)

        # render the show page for the HRs of the user
        return $this->render(
            'Profile/hotel_registrations_show.html.twig'
        );
    }

    /**
     * @Route("/profile/hotel_registration/{hotel_reg_id}/edit", name="hotel_reg_edit")
     */
    public function editAction(Request $request, $hotel_reg_id)
    {
        # TODO: stub for editing an HR

        # render the edit page for the hotel
        return $this->render(
            'Profile/hotel_registration_edit.html.twig', array(
            'hotel_reg_id' => $hotel_reg_id,
        ));
    }
}
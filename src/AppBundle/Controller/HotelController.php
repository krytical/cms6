<?php

// src/AppBundle/Controller/HotelController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Hotel;
use AppBundle\Form\HotelType;

class HotelController extends Controller
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function hotelAction()
    {

        # TODO: stub for main hotel page

        // renders the main hotel page
        return $this->render(
            'hotel/hotel.html.twig'
        );
    }
    /**
     * @Route("/hotel/{hotel_id}", name="hotel_show")
     */
    public function showAction($hotel_id)
    {
        # TODO: stub for showing a hotel

        # render the show page for the hotel
        return $this->render(
            'hotel/hotel_show.html.twig', array(
            'hotel_id' => $hotel_id,
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}/edit", name="hotel_edit")
     */
    public function editAction(Request $request, $hotel_id)
    {
        # TODO: stub for editing hotels

        # render the edit page for the hotel
        return $this->render(
            'hotel/hotel_edit.html.twig', array(
            'hotel_id' => $hotel_id,
        ));
    }

    # TODO: add some kind of controller that manages conference-hotel mappings
}
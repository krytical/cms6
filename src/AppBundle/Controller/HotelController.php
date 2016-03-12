<?php

// src/AppBundle/Controller/HotelController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Hotel;
use AppBundle\Form\HotelType;

use Symfony\Component\Form\Extension\Core\Type;

class HotelController extends Controller
{
    /**
     * @Route("/hotel", name="hotel")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function hotelAction(Request $request)
    {

        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();

            $this->addFlash(
                'success',
                'Hotel created successfully!'
            );

            return $this->redirectToRoute('_welcome');
        }

        // renders the main hotel page
        return $this->render(
            'hotel/hotel.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}", name="hotel_show")
     *
     * @param integer $hotel_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($hotel_id)
    {
        # TODO: stub for showing a hotel
        # (probably don't need this)

        # render the show page for the hotel
        return $this->render(
            'hotel/hotel_show.html.twig', array(
            'hotel_id' => $hotel_id,
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}/edit", name="hotel_edit")
     *
     * @param Request $request
     * @param integer $hotel_id
     * @return \Symfony\Component\HttpFoundation\Response
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

    # TODO: add a controller that manages conference-hotel mappings
}
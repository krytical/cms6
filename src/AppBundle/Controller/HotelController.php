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
     * @Route("/hotel", name="hotel_show_all")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAllAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotels
        $hotels = $helper->getAllHotels();

        return $this->render('hotel/hotel_show_all.html.twig', array(
            'hotels'=>$hotels,
        ));
    }

    /**
     * @Route("/hotel", name="hotel_create")
     *
     * @param Request $request
     *  The submitted HotelType form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($hotel);

            $this->addFlash(
                'success',
                'Hotel created successfully!'
            );

            return $this->redirectToRoute('_welcome');
        }

        // renders the hotel creation page
        return $this->render(
            'hotel/hotel_create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}", name="hotel_show")
     *
     * @param integer $hotel_id
     *  The id of the hotel to be displayed
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($hotel_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel
        $hotel = $helper->getHotel($hotel_id);
        if (!is_object($hotel) || !$hotel instanceof Hotel) {
            throw $this->createNotFoundException('The hotel you are trying to view does not exist.');
        }

        // get the hotel registrations for the hotel
        $hotel_registrations = $helper->getHotelRegistrationsByHotel($hotel_id);

        # TODO: count the columns of hotel registration for this hotel to get total number of registrations

        # render the show page for the hotel
        return $this->render(
            'hotel/hotel_show.html.twig', array(
            'hotel' => $hotel,
            'hotel_registrations' => $hotel_registrations
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}/edit", name="hotel_edit")
     *
     * @param Request $request
     *  The submitted HotelType form
     * @param integer $hotel_id
     *  The id of the hotel to be edited
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $hotel_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel
        $hotel = $helper->getHotel($hotel_id);
        if (!is_object($hotel) || !$hotel instanceof Hotel) {
            throw $this->createNotFoundException('The hotel you are trying to edit does not exist.');
        }

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $helper->setEntity($hotel);

            $this->addFlash(
                'success',
                'Hotel edited successfully!'
            );

            return $this->redirectToRoute('hotel_show_all');
        }

        # render the edit page for the hotel
        return $this->render(
            'hotel/hotel_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/hotel/{hotel_id}/delete", name="hotel_delete")
     *
     * @param string $hotel_id
     *  The id of the hotel to be deleted
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($hotel_id)
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the hotel
        $hotel = $helper->getHotel($hotel_id);
        if (!is_object($hotel) || !$hotel instanceof Hotel) {
            throw $this->createNotFoundException('The hotel you are trying to delete does not exist.');
        }

        $helper->deleteEntity($hotel);

        $this->addFlash(
            'success',
            'Hotel deleted successfully!'
        );

        return $this->redirectToRoute('hotel_show_all');
    }
}
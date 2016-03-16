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
     *  The submitted HotelType form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        # TODO: check user privileges
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

            return $this->redirectToRoute('hotel');
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
     *  The submitted HotelType form
     * @param integer $hotel_id
     *  The id of the hotel to be edited
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $hotel_id)
    {
        # TODO: check user privileges
        // get the hotel
        $hotel = $this->getDoctrine()
            ->getRepository('AppBundle:Hotel')
            ->find($hotel_id);
        if (!is_object($hotel) || !$hotel instanceof Hotel) {
            throw $this->createNotFoundException('The hotel you are trying to edit does not exist.');
        }

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();

            $this->addFlash(
                'success',
                'Hotel edited successfully!'
            );

            return $this->redirectToRoute('hotel');
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
        # TODO: check user privileges
        // get the hotel
        $hotel = $this->getDoctrine()
            ->getRepository('AppBundle:Hotel')
            ->find($hotel_id);
        if (!is_object($hotel) || !$hotel instanceof Hotel) {
            throw $this->createNotFoundException('The hotel you are trying to delete does not exist.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($hotel);
        $em->flush();

        $this->addFlash(
            'success',
            'Hotel deleted successfully!'
        );

        return $this->redirectToRoute('hotel');
    }
}
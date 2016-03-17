<?php

// src/AppBundle/Controller/EventController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

class EventController extends Controller
{
    /**
    * @Route("/event/{conf_id}", name="event")
    */
    public function eventAction(Request $request,$conf_id)
        {

            # TODO: I think this should be moved to createAction but it's up to you
            $conference = $this->getDoctrine()
                ->getRepository('AppBundle:Conference')
                ->find($conf_id);

            if (!$conference) {
                throw $this->createNotFoundException(
                'No product found for id '.$currentUrl
                );
            }

            $event = new Event();
            $event->setId($conference);
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Event created successfully!'
                );

                return $this->redirectToRoute('_welcome');
            }

        // renders the main event page
            return $this->render(
                'event/event.html.twig', array(
                'form' => $form->createView())
            );

        }

     /**
     * @Route("/conference/{conf_id}/event/{event_id}", name="event_show")
     */
     public function showAction($conf_id, $event_id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Event');

        $event = $repository -> findOneBy(
            array('conference_id' => $conf_id,'id' => $event_id)
        );
        

        if (!is_object($event) || !$event 
            instanceof Event) {
            throw $this->createNotFoundException('This event does not exist.');
        }

        # TODO: stub for showing a single event

        # render the show page for the event
        return $this->render(
            'conference/event/event_show.html.twig', array(
            'conf_id' => $conf_id,
            'event_id' => $event_id,
        ));
    }

    /**
     * @Route("/conference/{conf_id}/event/create", name="event_create")
     */
    public function createAction(Request $request, $conf_id)
    {
        # TODO: stub for creating an event

        # render the create page for events
        return $this->render(
            'conference/event_create.html.twig', array(
            'conf_id' => $conf_id,
        ));
    }

    /**
     * @Route("/conference/{conf_id}/event/{event_id}/edit", name="event_edit")
     */
    public function editAction(Request $request, $conf_id, $event_id)
    {
         $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Event');

        $event = $repository -> findOneBy(
            array('conference_id' => $conf_id,'id' => $event_id)
        );

         if (!is_object($event) || !$event 
            instanceof Event) {
            throw $this->createNotFoundException('This event you are trying to edit does not exist.');
        }
        
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->addFlash(
                'success',
                'Event edited successfully!'
            );

            return $this->redirectToRoute('conference_show_all');
        }

        # render the edit page for the event
        return $this->render(
            'conference/event_edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/conference/{conf_id}/event/{event_id}/delete", name="event_delete")
     */
    public function deleteAction(Request $request, $conf_id, $event_id)
    {
        # TODO: stub for deleting an event
         $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Event');

        $event = $repository -> findOneBy(
            array('conference_id' => $conf_id,'id' => $event_id)
        );

         if (!is_object($event) || !$event 
            instanceof Event) {
            throw $this->createNotFoundException('This event you are trying to delete does not exist.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        $this->addFlash(
            'success',
            'Event deleted successfully!'
        );

        # calls the homepage controller to render the homepage
        return $this->forward('AppBundle:Homepage:homepage');
    }
}
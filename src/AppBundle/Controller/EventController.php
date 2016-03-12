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
//    /**
//     * @Route("/event", name="event")
//     */
//    public function eventAction()
//    {
//        # TODO: stub for main event page (in case we want to do something with all events)
//        # (can probably remove)
//
//        // renders the main event page
//        return $this->render(
//            'event/event.html.twig'
//        );
//    }

//    /**
//     * @Route("/conference/{conf_id}/event", name="conference_events_show")
//     */
//    public function showConferenceEventsAction($conf_id)
//    {
//        # TODO: stub for showing all the events in a conference
//        # (probably don't need this, maybe just redirect to conference page)
//
//        # render the show page for the conference events
//        return $this->render(
//            'conference/event/conference_events_show.html.twig', array(
//            'conf_id' => $conf_id,
//        ));
//    }

    
    /**
    * @Route("/event/{conf_id}", name="event")
    */   

    public function eventAction(Request $request,$conf_id)
        {

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
                    'notice',
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
        # (not totally necessary but would be nice)

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

            return $this->redirectToRoute('conference');
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
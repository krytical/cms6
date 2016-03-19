<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        // get the conferences
        $conferences = $this->getDoctrine()
            ->getRepository('AppBundle:Conference')
            ->findAll();

		// map all conference ids to an array of their respective event objects
        // (<conf_id_1> => (<event_1>, <event_2>...), <conf_id_2> => ...)
        $events = array();
        foreach ($conferences as $conference){
            $conf_id = $conference->getID();
            $events[$conf_id] = $this->getDoctrine()
                ->getRepository('AppBundle:Event')
                ->findBy(array('conference' => $conf_id), array('id' => 'DESC'));
        }

        return $this->render('homepage/homepage.html.twig', array(
            'conferences'=>$conferences,
            'events' => $events
        ));
    }
}

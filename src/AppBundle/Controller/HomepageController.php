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
		$ids = array();
		$em = $this->getDoctrine()->getManager();
		$conferences = $em->getRepository('AppBundle:Conference')->findAll();
		
		// get the conference events
		for ($i =0; $i < count($conferences); $i++){
			$confevents = $this->getDoctrine()
				->getRepository('AppBundle:Event')
				->findBy(array('conference' => $conferences[$i]->getId()), array('id' => 'DESC'));
			$ids[] = 'conf_event'.($conferences[$i]->getId());
		}
		
		// If there are no conferences, $confevents is not instantiated
		// there is probably a better way of doing it but this works
		if (empty($conferences)){
			return $this->render('homepage/homepage.html.twig', array(
				'conferences'=>$conferences,
			));
		}
		else{	
			return $this->render('homepage/homepage.html.twig', array(
				'conferences'=>$conferences,
				//$ids => $confevents
			));
		}
    }
}

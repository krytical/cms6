<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        # TODO: Display a list of conferences
		
		/* THIS DOES NOT WORK YET
		$em = $this->getDoctrine()->getManager();
		$conferences = $em->getRepository('AppBundle\Entity\Conference')->findAll();
		$conferenceName = $conferences->getName();
		
		return $this->render('homepage/homepage.html.twig', 
			array('conferenceName'=>$conferenceName));
		*/
		$test = 'test';
		return $this->render('homepage/homepage.html.twig', array('conferenceName'=>$test));
    }
}

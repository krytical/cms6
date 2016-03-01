<?php

// src/AppBundle/Controller/HomepageController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Conference;
use AppBundle\Form\ConferenceType;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        # TODO: Display a list of conferences
		
		$em = $this->getDoctrine()->getManager();
		$conferences = $em->getRepository('AppBundle:Conference')->findAll();
		
		return $this->render('homepage/homepage.html.twig', 
			array('conferences'=>$conferences));
		

    }
}

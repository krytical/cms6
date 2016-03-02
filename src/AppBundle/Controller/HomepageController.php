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
		$em = $this->getDoctrine()->getManager();
		$conferences = $em->getRepository('AppBundle:Conference')->findAll();
		
		return $this->render('homepage/homepage.html.twig', 
			array('conferences'=>$conferences));
    }
}

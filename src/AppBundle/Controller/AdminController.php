<?php

// src/AppBundle/Controller/AdminController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
	 public function adminAction(){
		return $this->render('admin/admin.html.twig'); 
	 }
	
	/**
     * @Route("/admin/users", name="admin_user_list")
     */
    public function adminUsersAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get all the users
        $users = $helper->getAllUsers();

        return $this->render('admin/admin_users.html.twig', array(
            'users' => $users
        ));
    }
	
	/**
     * @Route("/admin/users", name="admin_request_list")
     */
    public function adminRequestsAction()
    {	
		// THIS PAGE WILL SHOW ONLY USERS WITH REQUESTS AND THE CONFERENCE
		// THEY ARE REQUESTING IN
		
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get all the users
        $users = $helper->getAllUsers();

        return $this->render('admin/admin_requests.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/transportation", name="transportation")
     */
    public function transportationAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get all the conferences
        $conferences = $helper->getAllConferences();

        // get all the conference registrations
        $conferenceRegs = $helper->getAllConferenceRegistrations();

        return $this->render('admin/transportation.html.twig', array(
            'conferences' => $conferences,
            'conference_regs' => $conferenceRegs
        ));
    }
}

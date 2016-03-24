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
    public function adminAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get all the users
        $users = $helper->getAllUsers();

        return $this->render('admin/admin.html.twig', array(
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

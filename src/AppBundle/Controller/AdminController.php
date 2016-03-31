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
     * @Route("/admin/users/{user_id}/approve", name="admin_user_approve")
     *
     * @param $user_id
     *  The ID of the user to be approved
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approveUserAction($user_id){
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $user = $helper->getUser($user_id);
        $user->setApproved(true);

        $helper->setEntity($user);

        // send the approval email
        if (!empty($user->getEmail())) {
            $message = \Swift_Message::newInstance()
                ->setSubject('CMS Account Approved!')
                ->setFrom($this->getParameter('contact_email'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/registration_approval.html.twig', array(
                            'name' => $user->getFirstName())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $this->addFlash(
                'success',
                'Account approved! An email has been sent to the user!'
            );
        }
        else {
            $this->addFlash(
                'success',
                'Account approved! No notification sent (User is not registered with an e-mail).'
            );
        }

        // render the users view
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/users/{user_id}/disapprove", name="admin_user_disapprove")
     *
     * @param $user_id
     *  The ID of the user to be disapproved
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disapproveUserAction($user_id){
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $user = $helper->getUser($user_id);
        $user->setApproved(false);

        $helper->setEntity($user);

        // render the users view
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/users/{user_id}/delete", name="admin_user_delete")
     *
     * @param string $user_id
     *  The ID of the user to be deleted
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction($user_id){
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $user = $helper->getUser($user_id);

        $helper->deleteEntity($user);

        $this->addFlash(
            'success',
            'User deleted successfully!'
        );

        // render the users view
        return $this->redirectToRoute('admin_user_list');
    }

	/**
     * @Route("/admin/users", name="admin_user_list")
     */
    public function adminUsersAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        $systemRoles = $this->container->getParameter('security.role_hierarchy.roles');

        // get all the users
        $users = $helper->getAllUsers();

        return $this->render('admin/admin_users.html.twig', array(
            'users' => $users,
            'roles' => $systemRoles
        ));
    }
	
//	/**
//     * @Route("/admin/requests", name="admin_request_list")
//     */
//    public function adminRequestsAction()
//    {
//
//        // THIS PAGE WILL SHOW ONLY USERS WITH REQUESTS AND THE CONFERENCE
//		// THEY ARE REQUESTING IN
//
//        // get the helper service and the EntityManager
//        $helper = $this->get('app.services.helper');
//        $helper->setEM($this->getDoctrine()->getEntityManager());
//
//        // get all the users
//        $users = $helper->getAllUsers();
//
//		// get all the conference registrations
//        $conferenceRegistrations = $helper->getAllConferenceRegistrations();
//
//        return $this->render('admin/admin_requests.html.twig', array(
//            'users' => $users,
//            'conf_regs' => $conferenceRegistrations,
//        ));
//    }

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

<?php

// src/AppBundle/Controller/ProfileController.php
namespace AppBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\UserBundle\Controller\ProfileController as BaseController;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        // get all the conference registrations for the user
        $conference_regs = $helper->getAllUsersConferenceRegistrations($user->getID());

        // get all the conference_registration_id to event registration mappings for the user
        $eventRegMap = $helper->conferenceRegEventRegMap($conference_regs);

        // get all the conference_registration_id to hotelRegistration mappings
        $hotel_regs = $helper->conferenceHotelRegistrationMap($conference_regs);

        # TODO: We may want to get ALL the events and just show the registered ones in a different color

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'conference_registrations' => $conference_regs,
			'event_registrations' => $eventRegMap,
            'hotel_registrations' => $hotel_regs
        ));
    }

    /**
     * @Route("/profile/delete", name="user_delete")
     */
    public function deleteAction()
    {
        // get the helper service and the EntityManager
        $helper = $this->get('app.services.helper');
        $helper->setEM($this->getDoctrine()->getEntityManager());

        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $helper->deleteEntity($user);

        # Log the user out by invalidating their session
        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        $this->addFlash(
            'success',
            'User deleted successfully!'
        );

        # calls the homepage controller to render the homepage
        return $this->forward('AppBundle:Homepage:homepage');
    }

}

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
        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        // get the conference registrations
        $registrations = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findBy(array('user' => $user->getId()), array('conference' => 'DESC'));

        # TODO: get the event registrations
        # TODO: get the hotel registrations

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'conference_registrations' => $registrations
        ));
    }

    /**
     * @Route("/profile/delete", name="user_delete")
     */
    public function deleteAction()
    {
        // get the user
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

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

<?php

// src/AppBundle/Controller/ProfileController.php
namespace AppBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $registrations = $this->getDoctrine()
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findBy(array('user' => $user->getId()), array('conference' => 'DESC'));

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

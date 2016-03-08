<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;


class SecurityRolesController extends Controller
{

    # TODO: solution for now is to submit everything as one form
    # ideally: the security roles page will have one form per row (one row per user)


    /**
     * @Route("/security_roles", name="security_roles_show")
     */
    public function showAction()
    {
        # TODO: stub for showing all the assigned roles for all users
        # we might want to sort them later by regular users vs users with special permissions


        # need list of users with security roles
        # need list of security roles
        $roles = $this->container->getParameter('security.role_hierarchy.roles');

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();


        return $this->render(
            'Security/security_roles_show.html.twig', array(
                'roles' => $roles,
                'users' => $users
            )
        );
    }

    /**
     *  @Route("/security_roles/edit", name="security_roles_edit")
     */
    public function editAction(Request $request)
    {
        # TODO: create form
        # update each user at a time

        # render the edit page for the event
        return $this->render(
            'Security/security_roles_edit.html.twig'
        );
    }

    private function updateUsers($users){
        # $users = User array (delete or ignore this comment
        foreach($users as $user){
            # udpate user
        }
    }

}
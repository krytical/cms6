<?php

namespace AppBundle\Controller;

use AppBundle\Resources\HelperClasses\UserRole;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Form\UserRoleType;


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
        # update one user at a time

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render(
            'Security/security_roles_edit.html.twig'
        );
    }


    /**
     *  @Route("/security_roles/edit_user", name="security_roles_edit.html.twig")
     * TODO: temporary controller action to edit a single user at a time
     */
    public function editUserRoleAction(Request $request)
    {

        # TODO: get user by user id from request?

        # for now I'll just choose one random user
        $systemRoles = $this->container->getParameter('security.role_hierarchy.roles');
        $user = $this->getUser(); // TODO: need user ID of user being edited not signed in user
        //$user->addRole('ROLE_ADMIN'); // dummy line
        $userRoles = $user->getRoles();


        //$form = $this->createForm(UserRoleType::class, $user);

        $rolesWithStatus =  $this->getEnabledStatusForRoles($systemRoles, $userRoles);

        /*$form->handleRequest($request); OR
        if ($form->isSubmitted() && $form->isValid()){
          DO SOMETHING
        ie. persist to db and redirect
        }


        # TODO: for updating user, use userManager
        $userManager = $this->container->get('fos_user.user_manager');
        if ($form->isValid()) {
            $userManager->updateUser($user);

           // return $this->redirect($this->generateUrl('wes_admin_user_edit',
             //   array('id' => $id)));
        }*/

        return $this->render(
            'Security/security_roles_edit.html.twig', array(
               // 'form' => $form->createView(),
                'user' => $user,
                'userRoles' => $userRoles,
                'roles' => $rolesWithStatus,
                'systemRoles' => $systemRoles,
            )
        );

    }

    //TODO: find better solution to get role name
    // ideally, we would get role name from request
    // can't figure out how to create request from form cuz its just a redirect button
    //look info form types maybe?
    /**
     *  @Route("/security_roles/{userID}/user_add_role/{role}")
     */
    public function addRoleAction($userID, $role){
        //TODO: need user ID of user being edited not signed in user
        //TODO: need role name


        //get user
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userID));
        $user->addRole($role);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        #redirect to edit user role action
         return $this->redirect($this->generateUrl('security_roles_edit_user'));
    }


    private function getEnabledStatusForRoles($systemRoles, $userRoles){
        $rolesWithStatus = array();
        foreach($systemRoles as $systemRole){
            $currRole = new UserRole($systemRole[0]);
            if(in_array($systemRole[0], $userRoles)){
                $currRole->setEnabled(true);
            }
            else{
                $currRole->setEnabled(false);
            }
            $rolesWithStatus[] = $currRole;
        }
        return $rolesWithStatus;
    }

}
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
     * @Route("/security_roles/users", name="security_roles_users")
     */
    public function showAction()
    {
        # we might want to sort them later by regular users vs users with special permissions

        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();


        return $this->render(
            'Security/security_roles_show.html.twig', array(
                'users' => $users
            )
        );
    }


    /**
     *  @Route("/security_roles/{usedID}/edit", name="security_roles_edit.html.twig")
     * TODO: temporary controller action to edit a single user at a time
     */
    public function editUserRolesAction(Request $request, $userID)
    {

        # TODO: get user by user id from request?

        $systemRoles = $this->container->getParameter('security.role_hierarchy.roles');

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$userID));
        $userRoles = $user->getRoles();


        $rolesWithStatus =  $this->getEnabledStatusForRoles($systemRoles, $userRoles);


        return $this->render(
            'Security/security_roles_edit_user.html.twig', array(
                'user' => $user,
                'userRoles' => $userRoles,
                'roles' => $rolesWithStatus,
                'systemRoles' => $systemRoles,
            )
        );

    }

    //TODO: find better solution to get role name
    /**
     *  @Route("/security_roles/{userID}/user_add_role/{role}")
     */
    public function addRoleAction($userID, $role){
        //get user
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userID));
        $user->addRole($role);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        $user = $userManager->findUserBy(array('id' => $userID));
        //TODO: adding the right roles is not working
        if ($this->isGranted($role, $user) && $user->hasRole($role)){
            $message = $role." added successfully";

            $this->addFlash(
                'success',
                $message
            );
        }


        #redirect to edit user role action
        return $this->redirect($this->generateUrl('security_roles_edit_user', array('userId' => $userID)));
    }

    //TODO: find better solution to get role name
    /**
     *  @Route("/security_roles/{userID}/user_remove_role/{role}")
     */
    public function removeRoleAction($userID, $role){

        //get user
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userID));
        $user->removeRole($role);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        if (!$this->isGranted($role, $user) && !$user->hasRole($role)){
            $message = $role." removed successfully";

            $this->addFlash(
                'success',
                $message
            );
        }

        return $this->redirect($this->generateUrl('security_roles_edit_user', array('userId' => $userID)));
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
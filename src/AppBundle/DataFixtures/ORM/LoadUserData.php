<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface,ContainerAwareInterface
{

    /*
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');

        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('admin');

        $userAdmin->setPlainPassword('pass');

        $userAdmin->setFirstName('DefaultFN');
        $userAdmin->setLastName('DefaultLN');
        $userAdmin->setEmail('default@admin.com');

        $userAdmin->setApproved(true);
        $userAdmin->setEnabled(true);

        $userAdmin->setRoles(array('ROLE_ADMIN'));

        $userManager->updateUser($userAdmin, true);

    }
}
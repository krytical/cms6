<?php

// src/AppBundle/Services/Helper.php
namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Conference;
use Proxies\__CG__\AppBundle\Entity\ConferenceRegistration;


/**
 * This class provides helper methods for all our controllers to
 * avoid duplicate code. Any functionality that has to be shared
 * between controllers can be extracted into a method here.
 */
class Helper
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Sets the entity manager for the helper
     *
     * @param EntityManager $em
     */
    public function setEM($em)
    {
        $this->em = $em;
    }

    public function setEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function deleteEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    # ----------------
    # CONFERENCES
    # ----------------

    /**
     * @param string $conf_id
     *
     * @return Conference
     */
    public function getConference($conf_id)
    {
        return $this->em
            ->getRepository('AppBundle:Conference')
            ->find($conf_id);
    }

    public function getAllConferences()
    {
        return $this->em
            ->getRepository('AppBundle:Conference')
            ->findAll();
    }

    # ----------------
    # EVENTS
    # ----------------

    public function getEvent($conf_id, $event_id)
    {
        return $this->em
            ->getRepository('AppBundle:Event')
            ->findOneBy(array('conference' => $conf_id,'id' => $event_id));
    }

    public function getConferenceEvents($conf_id)
    {
        return $this->em
            ->getRepository('AppBundle:Event')
            ->findBy(array('conference' => $conf_id), array('id' => 'DESC'));
    }

    /**
     *
     *  map all conference ids to an array of their respective event objects
     *  ex. (<conf_id_1> => (<event_1>, <event_2>...), <conf_id_2> => ...)
     *
     * @param Conference[] $conferences
     *
     * @return array $events
     *
     */
    public function conferenceEventMap($conferences)
    {
        $events = array();
        foreach ($conferences as $conference){
            $conf_id = $conference->getID();
            $events[$conf_id] = $this->em
                ->getRepository('AppBundle:Event')
                ->findBy(array('conference' => $conf_id), array('id' => 'DESC'));
        }

        return $events;
    }

    # ----------------
    # CONFERENCE REGISTRATIONS
    # ----------------

    public function getConferenceRegistration($conf_reg_id)
    {
        return $this->em
            ->getRepository('AppBundle:ConferenceRegistration')
            ->find($conf_reg_id);
    }

    public function getAllConferenceRegistrations()
    {
        return $this->em
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findAll();
    }

    public function getUsersConferenceRegistration($user_id, $conference_id)
    {
        return $this->em
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findOneBy(array('user' => $user_id, 'conference' => $conference_id));
    }

    public function getAllUsersConferenceRegistrations($user_id)
    {
        return $this->em
            ->getRepository('AppBundle:ConferenceRegistration')
            ->findBy(array('user' => $user_id), array('conference' => 'DESC'));
    }

    # ----------------
    # EVENT REGISTRATIONS
    # ----------------

    public function getEventRegistration($event_reg_id)
    {
        return $this->em
            ->getRepository('AppBundle:EventRegistration')
            ->find($event_reg_id);
    }

    public function getUsersEventRegistration($user_id, $event_id)
    {
        return $this->em
            ->getRepository('AppBundle:EventRegistration')
            ->findOneBy(array('user' => $user_id, 'event' => $event_id));
    }

    /**
     *
     * map all conference registration ids to an array of their respective event registration objects
     *
     * ex. (<conf_id_1> => (<event_reg_1>, <event_reg_2>), <conf_id_2> => ...)
     *
     * @param ConferenceRegistration[] $conferenceRegs
     *
     * @return array $event_reg_ids
     *
     */
    public function conferenceRegEventRegMap($conferenceRegs)
    {
        $event_reg_ids = array();
        foreach ($conferenceRegs as $conferenceReg){
            $conf_reg_id = $conferenceReg->getID();
            $event_reg_ids[$conf_reg_id] = $this->em
                ->getRepository('AppBundle:EventRegistration')
                ->findBy(array('conferenceRegistration' => $conf_reg_id), array('event' => 'DESC'));
        }
        return $event_reg_ids;
    }

    # ----------------
    # HOTELS
    # ----------------

    public function getAllHotels()
    {
        return $this->em
            ->getRepository('AppBundle:Hotel')
            ->findAll();
    }

    public function getHotel($hotel_id)
    {
        return $this->em
            ->getRepository('AppBundle:Hotel')
            ->find($hotel_id);
    }

    # ----------------
    # HOTEL REGISTRATIONS
    # ----------------

    public function getHotelRegistration($conf_reg_id)
    {
        return $this->em
            ->getRepository('AppBundle:HotelRegistration')
            ->findOneBy(array('conferenceRegistration' => $conf_reg_id));
    }

    /**
     *
     * map all conference ids to an array of their respective hotelRegistration objects
     *
     * NOTE there should only be one hotel registration for each conference registration
     *      but we're returning an array of them just in case
     *
     * ex. (<conf_id_1> => (<hotel_reg_1>, <hotel_reg_2>), <conf_id_2> => ...)
     *
     * @param ConferenceRegistration[] $registrations
     *
     * @return array $hotel_regs
     *
     */
    public function conferenceHotelRegistrationMap($registrations)
    {
        $hotel_regs = array();
        foreach ($registrations as $conf_reg) {
            $conf_id = $conf_reg->getID();
            $hotel_regs[$conf_id] = $this->em
                ->getRepository('AppBundle:HotelRegistration')
                ->findBy(array('conferenceRegistration' => $conf_id), array('id' => 'DESC'));
        }

        return $hotel_regs;
    }
}

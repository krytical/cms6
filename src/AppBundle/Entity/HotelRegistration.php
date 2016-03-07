<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * HotelRegistration
 *
 * @ORM\Table(name="hotel_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HotelRegistrationRepository")
 */
class HotelRegistration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="ConferenceRegistration", inversedBy="hotel_registration")
     * @ORM\JoinColumn(name="conference_registration_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conferenceRegistration;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $hotel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_in_datetime", type="datetime", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="Please enter the check in datetime.",
     *     groups={"HotelRegistration"})
     * @Assert\DateTime(
     *     message="Please enter a valid datetime.",
     *     groups={"HotelRegistration"})
     */
    private $checkInDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_out_datetime", type="datetime", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="Please enter the check out datetime.",
     *     groups={"HotelRegistration"})
     * @Assert\DateTime(
     *     message="Please enter a valid datetime.",
     *     groups={"HotelRegistration"})
     */
    private $checkOutDatetime;

    /**
     * @var string
     *
     * @ORM\Column(name="room", type="string", length=50, nullable=true)
     *
     * @Assert\Length(
     *     max=50,
     *     maxMessage="The room name is too long.",
     *     groups={"HotelRegistration"})
     */
    private $room;

    public function __construct()
    {
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set conferenceRegistration
     *
     * @param \AppBundle\Entity\ConferenceRegistration $conferenceRegistration
     * @return HotelRegistration
     */
    public function setConferenceRegistration(\AppBundle\Entity\ConferenceRegistration $conferenceRegistration = null)
    {
        $this->conferenceRegistration = $conferenceRegistration;

        return $this;
    }

    /**
     * Get conferenceRegistration
     *
     * @return \AppBundle\Entity\ConferenceRegistration
     */
    public function getConferenceRegistration()
    {
        return $this->conferenceRegistration;
    }

    /**
     * Set hotel
     *
     * @param \AppBundle\Entity\Hotel $hotel
     * @return HotelRegistration
     */
    public function setHotel(\AppBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \AppBundle\Entity\Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set checkInDatetime
     *
     * @param \DateTime $checkInDatetime
     * @return HotelRegistration
     */
    public function setCheckInDatetime($checkInDatetime)
    {
        $this->checkInDatetime = $checkInDatetime;

        return $this;
    }

    /**
     * Get checkInDatetime
     *
     * @return \DateTime 
     */
    public function getCheckInDatetime()
    {
        return $this->checkInDatetime;
    }

    /**
     * Set checkOutDatetime
     *
     * @param \DateTime $checkOutDatetime
     * @return HotelRegistration
     */
    public function setCheckOutDatetime($checkOutDatetime)
    {
        $this->checkOutDatetime = $checkOutDatetime;

        return $this;
    }

    /**
     * Get checkOutDatetime
     *
     * @return \DateTime 
     */
    public function getCheckOutDatetime()
    {
        return $this->checkOutDatetime;
    }

    /**
     * Set room
     *
     * @param string $room
     * @return HotelRegistration
     */
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return string 
     */
    public function getRoom()
    {
        return $this->room;
    }
}

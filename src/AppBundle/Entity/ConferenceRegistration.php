<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConferenceRegistration
 *
 * @ORM\Table(name="conference_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceRegistrationRepository")
 */
class ConferenceRegistration
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Conference")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\Type(type="AppBundle\Entity\Conference")
     * @Assert\Valid()
     */
    private $conference;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="HotelRegistration", mappedBy="conference_registration")\
     * @ORM\JoinColumn(name="hotel_registration_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\Type(type="AppBundle\Entity\HotelRegistration")
     * @Assert\Valid()
     */
    private $hotelRegistration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_datetime", type="datetime", nullable=true)
     *
     * @Assert\Date(
     *     message="Please enter a valid date.",
     *     groups={"ConferenceRegistration"})
     */
    private $arrivalDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_datetime", type="datetime", nullable=true)
     *
     * @Assert\Date(
     *     message="Please enter a valid date.",
     *     groups={"ConferenceRegistration"})
     */
    private $departureDatetime;

    /**
     * @var int
     *
     * @ORM\Column(name="guests", type="integer")
     *
     * @Assert\NotBlank(
     *     message="Please enter the number of guests attending.",
     *     groups={"ConferenceRegistration"})
     *  @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"ConferenceRegistration"})
     */
    private $guests;

    /**
     * @var string
     *
     * @ORM\Column(name="accommodations", type="string")
     *
     */
    private $accommodations;

    /**
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     *
     * @Assert\NotBlank(
     *     message="Please enter approved true or false.",
     *     groups={"ConferenceRegistration"})
     */
    private $approved;

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
     * Set arrivalDatetime
     *
     * @param \DateTime $arrivalDatetime
     * @return ConferenceRegistration
     */
    public function setArrivalDatetime($arrivalDatetime)
    {
        $this->arrivalDatetime = $arrivalDatetime;

        return $this;
    }

    /**
     * Get arrivalDatetime
     *
     * @return \DateTime 
     */
    public function getArrivalDatetime()
    {
        return $this->arrivalDatetime;
    }

    /**
     * Set departureDatetime
     *
     * @param \DateTime $departureDatetime
     * @return ConferenceRegistration
     */
    public function setDepartureDatetime($departureDatetime)
    {
        $this->departureDatetime = $departureDatetime;

        return $this;
    }

    /**
     * Get departureDatetime
     *
     * @return \DateTime
     */
    public function getDepartureDatetime()
    {
        return $this->departureDatetime;
    }

    /**
     * Set guests
     *
     * @param integer $guests
     * @return ConferenceRegistration
     */
    public function setGuests($guests)
    {
        $this->guests = $guests;

        return $this;
    }

    /**
     * Get guests
     *
     * @return integer 
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return ConferenceRegistration
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set accommodations
     *
     * @param string $accommodations
     * @return ConferenceRegistration
     */
    public function setAccommodations($accommodations)
    {
        $this->accommodations = $accommodations;

        return $this;
    }

    /**
     * Get accommodations
     *
     * @return string 
     */
    public function getAccommodations()
    {
        return $this->accommodations;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return ConferenceRegistration
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set conference
     *
     * @param \AppBundle\Entity\Conference $conference
     * @return ConferenceRegistration
     */
    public function setConference(\AppBundle\Entity\Conference $conference = null)
    {
        $this->conference = $conference;

        return $this;
    }

    /**
     * Get conference
     *
     * @return \AppBundle\Entity\Conference
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * Set hotelRegistration
     *
     * @param \AppBundle\Entity\HotelRegistration $hotelRegistration
     * @return ConferenceRegistration
     */
    public function setHotelRegistration(\AppBundle\Entity\HotelRegistration $hotelRegistration = null)
    {
        $this->hotelRegistration = $hotelRegistration;

        return $this;
    }

    /**
     * Get hotelRegistration
     *
     * @return \AppBundle\Entity\HotelRegistration
     */
    public function getHotelRegistration()
    {
        return $this->hotelRegistration;
    }
}

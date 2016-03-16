<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConferenceHotelMap
 *
 * @ORM\Table(name="conference_hotel_map")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceHotelMapRepository")
 */
class ConferenceHotelMap
{
    #TODO: DELETE THIS FILE

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
     * @ORM\ManyToOne(targetEntity="Conference")
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $conference;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $hotel;

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
     * Set conference
     *
     * @param \AppBundle\Entity\Conference $conference
     * @return ConferenceHotelMap
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
     * Set hotel
     *
     * @param \AppBundle\Entity\Hotel $hotel
     * @return ConferenceHotelMap
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
}

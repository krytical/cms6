<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventRegistration
 *
 * @ORM\Table(name="event_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRegistrationRepository")
 */
class EventRegistration
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
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $event;

    /**
     * @var int
     *
     * @ORM\Column(name="guests", type="integer")
     *
     * @Assert\NotBlank(
     *     message="Please enter the number of guests attending.",
     *     groups={"EventRegistration"})
     *  @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"EventRegistration"})
     */
    private $guests;

    /**
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     *
     * @Assert\NotBlank(
     *     message="Please enter approved true or false.",
     *     groups={"EventRegistration"})
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return EventRegistration
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
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     * @return EventRegistration
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set guests
     *
     * @param integer $guests
     * @return EventRegistration
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
     * @return EventRegistration
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
}

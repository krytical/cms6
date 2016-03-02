<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
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
     * @ORM\ManyToOne(targetEntity="Conference") 
     * @ORM\JoinColumn(name="conference_id", referencedColumnName="id")
     */
    protected $conference;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter the name of the event.",
     *     groups={"Event"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The event name is too long.",
     *     groups={"Event"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string")
     *
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter the location of the event.",
     *     groups={"Event"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The location name is too long.",
     *     groups={"Event"})
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="speaker", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter the speaker of the event.",
     *     groups={"Event"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The speaker name is too long.",
     *     groups={"Event"})
     */
    private $speaker;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_datetime", type="datetime")
     *
     * @Assert\NotBlank(
     *     message="Please enter the start date of the event.",
     *     groups={"Event"})
     * @Assert\Date(
     *     message="Please enter a valid date.",
     *     groups={"Event"})
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_datetime", type="datetime")
     *
     * @Assert\NotBlank(
     *     message="Please enter the end date of the event.",
     *     groups={"Event"})
     * @Assert\Date(
     *     message="Please enter a valid date.",
     *     groups={"Event"})
     */
    private $endDatetime;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer", nullable=true)
     *
     *  @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"Event"})
     */
    private $capacity;

    /**
     * @var int
     *
     * @ORM\Column(name="spots_remaining", type="integer", nullable=true)
     *
     *  @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"Event"})
     */
    private $spotsRemaining;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="img_name", type="string", length=100, nullable=true)
//     */
//    private $imgName;

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
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set speaker
     *
     * @param string $speaker
     * @return Event
     */
    public function setSpeaker($speaker)
    {
        $this->speaker = $speaker;

        return $this;
    }

    /**
     * Get speaker
     *
     * @return string 
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     * @return Event
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime
     *
     * @return \DateTime 
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime
     *
     * @param \DateTime $endDatetime
     * @return Event
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime 
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Event
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set spotsRemaining
     *
     * @param integer $spotsRemaining
     * @return Event
     */
    public function setSpotsRemaining($spotsRemaining)
    {
        $this->spotsRemaining = $spotsRemaining;

        return $this;
    }

    /**
     * Get spotsRemaining
     *
     * @return integer 
     */
    public function getSpotsRemaining()
    {
        return $this->spotsRemaining;
    }

//    /**
//     * Set imgName
//     *
//     * @param string $imgName
//     * @return Event
//     */
//    public function setImgName($imgName)
//    {
//        $this->imgName = $imgName;
//
//        return $this;
//    }
//
//    /**
//     * Get imgName
//     *
//     * @return string
//     */
//    public function getImgName()
//    {
//        return $this->imgName;
//    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Event
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Event
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set conference
     *
     * @param \AppBundle\Entity\Conference $conference
     * @return Event
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
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}

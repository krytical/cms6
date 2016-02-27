<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Conference
 *
 * @ORM\Table(name="conference")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceRepository")
 */
class Conference
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter the name of the Conference.",
     *     groups={"Conference"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The conference name is too long.",
     *     groups={"Conference"})
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
     *     message="Please enter the location of the Conference.",
     *     groups={"Conference"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The location name is too long.",
     *     groups={"Conference"})
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_datetime", type="datetime")
     *
     * @Assert\NotBlank(
     *     message="Please enter the start date of the Conference.",
     *     groups={"Conference"})
     * @Assert\DateTime(
     *     message="Please enter a valid date.",
     *     groups={"Conference"})
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_datetime", type="datetime")
     *
     * @Assert\NotBlank(
     *     message="Please enter the end date of the Conference.",
     *     groups={"Conference"})
     * @Assert\DateTime(
     *     message="Please enter a valid date.",
     *     groups={"Conference"})
     */
    private $endDatetime;

    /**
     * @var string
     *
     * @ORM\Column(name="img_name", type="string", length=100, nullable=true)
     */
    private $imgName;

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
     * @return Conference
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
     * @return Conference
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Conference
     */
    public function setStartDate($startDate)
    {
        # TODO: make this = $startDate
        $this->startDate = new \DateTime("now");

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Conference
     */
    public function setEndDate($endDate)
    {
        # TODO: make this = $endDate
        $this->endDate = new \DateTime("now");

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set imgName
     *
     * @param string $imgName
     * @return Conference
     */
    public function setImgName($imgName)
    {
        $this->imgName = $imgName;

        return $this;
    }

    /**
     * Get imgName
     *
     * @return string 
     */
    public function getImgName()
    {
        return $this->imgName;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint('name', new NotBlank());

        $metadata->addPropertyConstraint('location', new NotBlank());
        $metadata->addPropertyConstraint('startDate', new Assert\Date());

        $metadata->addPropertyConstraint('startDate', new Assert\Date());
    }



    /**
     * Set description
     *
     * @param string $description
     * @return Conference
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

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     * @return Conference
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
     * @return Conference
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
}

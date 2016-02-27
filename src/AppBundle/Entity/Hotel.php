<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HotelRepository")
 */
class Hotel
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
     *     message="Please enter the name of the hotel.",
     *     groups={"Hotel"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The hotel name is too long.",
     *     groups={"Hotel"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter the location of the hotel.",
     *     groups={"Hotel"})
     * @Assert\Length(
     *     max=100,
     *     maxMessage="The location name is too long.",
     *     groups={"Hotel"})
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer", nullable=true)
     *
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"Hotel"})
     */
    private $capacity;

    /**
     * @var int
     *
     * @ORM\Column(name="vacancy", type="integer", nullable=true)
     *
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Please enter a value of at least zero.",
     *      groups={"Hotel"})
     */
    private $vacancy;

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
     * @return Hotel
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
     * @return Hotel
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
     * Set capacity
     *
     * @param integer $capacity
     * @return Hotel
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
     * Set vacancy
     *
     * @param integer $vacancy
     * @return Hotel
     */
    public function setVacancy($vacancy)
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    /**
     * Get vacancy
     *
     * @return integer 
     */
    public function getVacancy()
    {
        return $this->vacancy;
    }

    /**
     * Set imgName
     *
     * @param string $imgName
     * @return Hotel
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
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Conference
 *
 * @ORM\Table(name="conference")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConferenceRepository")
 * @Vich\Uploadable
 */
class Conference
{

    # TODO: add text column containing larger description of conference

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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="conference_image", fileNameProperty="imageName")
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

//    /**
//     * Set imgName
//     *
//     * @param string $imgName
//     * @return Conference
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
     * @return Conference
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
     * @return Conference
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
}

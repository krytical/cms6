<?php

namespace AppBundle\Entity;

use AppBundle\Resources\HelperClasses\SecurityRole;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Vich\Uploadable
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(name="username", type="string", length=25, unique=true)
 *      ),
 *     @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(name="email", type="string", length=50, unique=true, nullable=true)
 *      )
 * })
 */
class User extends BaseUser
{
    # TODO: maybe add columns:  birthday, country, gender

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter your first name.",
     *     groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter your last name.",
     *     groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"})
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=25, nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="The phone number is too short.",
     *     maxMessage="The phone number is too long.",
     *     groups={"Registration", "Profile"})
     */
    private $phone;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(name="img_name", type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     *
    private $updatedAt;*/

    /**
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     *
     * @Assert\NotBlank(
     *     message="Please enter approved true or false.",
     *     groups={"User"})
     */
    private $approved;

// These need to be here for some reason. Sometimes they need to be uncommented
// when running migrations.

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="username", type="string", length=25, unique=true)
//     */
//    protected $username;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="password", type="string", length=25)
//     */
//    protected $password;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="email", type="string", length=50, unique=true, nullable=true)
//     */
//    protected $email;



    // TODO: temporary solution for serialized roles for form usage
    /**
     * @var array
    */
    private $userRoles;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Get id
     *
     *
     * @return User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get first name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return User
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
     * @return User
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
     * Set approved
     *
     * @param boolean $approved
     * @return User
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


    //TODO: this is a temporary solution...not the best solution ATM however


    /**
    * Get serialized array of roles for form
     * @return array
     * of SecurityRole type
     */
    public function getUserRoles(){
        $userRoles = array();
        $this->getRoles();

        foreach ($userRoles as $role){
            $userRoles.array_push($role);
        }

        return $userRoles;
    }
}

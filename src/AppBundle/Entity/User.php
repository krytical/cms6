<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(name="username", type="string", length=25, unique=true)
 *      ),
 *     @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(name="email", type="string", length=50, unique=true, nullable=true)
 *      ),
 *     @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(name="password", type="string", length=25)
 *      )
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     *
     * @Assert\NotBlank(
     *     message="Please enter your name.",
     *     groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"})
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(name="img_name", type="string", length=100, nullable=true)
     */
    private $imgName;

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
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set imgName
     *
     * @param string $imgName
     * @return User
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
}

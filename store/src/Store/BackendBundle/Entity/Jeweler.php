<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Jeweler
 *
 * @ORM\Table(name="jeweler", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\JewelerRepository")
 * @UniqueEntity(fields = "username", message = "Votre pseudo existe déjà", groups = {"register"})
 * @UniqueEntity(fields = "email", message = "Votre email existe déjà", groups = {"register"})
 */
class Jeweler implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=300, nullable=true)
     * @Assert\NotBlank(message = "Le login ne doit pas être vide", groups = {"register"})
     * @Assert\Length(
     *         min= "6",
     *         max = "50",
     *         minMessage = "Le login doit contenir au moins {{ limit }} caractères",
     *         maxMessage = "Le login peut contenir au plus {{ limit }} caractères",
     *         groups ={"register"}
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     * @Assert\NotBlank(message = "L'e-mail ne doit pas être vide", groups = {"register"})
     * @Assert\Email(message ="'{{ value }}' n'est pas un email valide", checkMX = true, groups = {"register"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=300, nullable=true)
     * @Assert\NotBlank(message = "Le password ne doit pas être vide", groups = {"register"})
     * @Assert\Length(
     *         min= "6",
     *         max = "50",
     *         minMessage = "Le password doit contenir au moins {{ limit }} caractères",
     *         maxMessage = "Le password peut contenir au plus {{ limit }} caractères",
     *         groups ={"register"}
     * )
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=300, nullable=true)
     * @Assert\NotBlank(message = "Le titre ne doit pas être vide", groups = {"register"})
     * @Assert\Length(
     *         min= "6",
     *         max = "300",
     *         minMessage = "Le titre doit contenir au moins {{ limit }} caractères",
     *         maxMessage = "Le titre peut contenir au plus {{ limit }} caractères",
     *         groups ={"register"}
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=300, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean", nullable=true)
     */
    private $locked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     */
    private $expired;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=300, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=300, nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=300, nullable=true)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=300, nullable=true)
     */
    private $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentials_expired", type="boolean", nullable=true)
     */
    private $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    private $credentialsExpireAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=300, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="password_requested_at", type="string", length=300, nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="fid", type="integer", nullable=true)
     */
    private $fid;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonLocked", type="boolean", nullable=true)
     */
    private $accountnonlocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonExpired", type="boolean", nullable=true)
     */
    private $accountnonexpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_auth", type="datetime", nullable=true)
     */
    private $dateAuth;

    /**
     * @ORM\ManyToMany(targetEntity="Groups", inversedBy="jeweler")
     * @ORM\JoinTable(name="jeweler_groups" ,
     *   joinColumns = {
     *     @ORM\JoinColumn(name="jeweler_id", referencedColumnName = "id")
     *   },
     *   inverseJoinColumns = {
     *     @ORM\JoinColumn(name="groups_id", referencedColumnName = "id")
     *   }
     * )
     *
     */
    private $groups;


    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setDefaultValues();
    }

    public function setDefaultValues()
    {
        $this->dateCreated        = new \DateTime('now');
        $this->type               = 1;
        $this->enabled            = 1;
        $this->accountnonlocked   = 1;
        $this->accountnonexpired  = 1;
        $this->credentialsExpired = 1;
        $this->expired            = 0;
        $this->locked             = 0;
        $this->salt               = md5(uniqid(mt_rand(),true));
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
     * Set username
     *
     * @param string $username
     * @return Jeweler
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Jeweler
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Jeweler
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Jeweler
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Jeweler
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
     * Set image
     *
     * @param string $image
     * @return Jeweler
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Jeweler
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Jeweler
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Jeweler
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateAuth
     */
    public function setDateAuth($dateAuth)
    {
        $this->dateAuth = $dateAuth;
    }

    /**
     * @return \DateTime
     */
    public function getDateAuth()
    {
        return $this->dateAuth;
    }



    /**
     * Set locked
     *
     * @param boolean $locked
     * @return Jeweler
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean 
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     * @return Jeweler
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean 
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Jeweler
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Jeweler
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     * @return Jeweler
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * Get usernameCanonical
     *
     * @return string 
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * Set emailCanonical
     *
     * @param string $emailCanonical
     * @return Jeweler
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * Get emailCanonical
     *
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }



    #METHODS IMPLEMENTED BY AdvancedUserInterface

    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    public function setFid($fid)
    {
        $this->fid = $fid;

        return $this;
    }

    public function getFid()
    {
        return $this->fid;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setAccountnonlocked($accountnonlocked)
    {
        $this->accountnonlocked = $accountnonlocked;

        return $this;
    }

    public function getAccountnonlocked()
    {
        return $this->accountnonlocked;
    }

    public function setAccountnonexpired($accountnonexpired)
    {
        $this->accountnonexpired = $accountnonexpired;

        return $this;
    }

    public function getAccountnonexpired()
    {
        return $this->accountnonexpired;
    }

    public function isAccountNonExpired()
    {
        return $this->accountnonexpired;
    }

    public function isAccountNonLocked()
    {
        return $this->accountnonlocked;
    }

    public function isCredentialsNonExpired()
    {
        return $this->credentialsExpired;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getRoles()
    {
        // return ['ROLE_JEWELER'];
        return $this->groups->toArray();
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function isEqualTo(UserInterface $user){
        return $this->username === $user->getUsername();
    }

    #METHODS IMPLEMENTED BY \Serializable
    public function serialize()
    {
        return serialize([$this->id]);
    }

    public function unserialize($serialized)
    {
        list($this->id) = unserialize($serialized);
    }

    /**
     * Return title
     * @return string
     */
    function __toString()
    {
        return (string)$this->title;
    }
    /**
     * Constructor
     */

    /**
     * Add groups
     *
     * @param \Store\BackendBundle\Entity\Groups $groups
     * @return Jeweler
     */
    public function addGroup(\Store\BackendBundle\Entity\Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Store\BackendBundle\Entity\Groups $groups
     */
    public function removeGroup(\Store\BackendBundle\Entity\Groups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @Assert\Callback(groups = {"register"})
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context){
        if($this->getUsername() == $this->getPassword()) {
            $context->addViolationAt('email', 'Votre email ne doit pas être identique à votre mot de passe',[],null);
        }
        if($this->getUsername() == $this->getEmail()) {
            $context->addViolationAt('email', 'Votre email ne doit pas être identique à votre login',[],null);
        }
    }
}

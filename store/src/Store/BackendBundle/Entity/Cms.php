<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cms
 *
 * @ORM\Table(name="cms", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\CmsRepository")
 */
class Cms
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
     * @ORM\Column(name="title", type="string", length=300, nullable=true)
     * @Assert\Length(
     * min = "6",
     * max = "100",
     * minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre titre peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "La titre ne doit pas être vide")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     * @Assert\Length(
     * min = "11",
     * max = "100",
     * minMessage = "Votre résumé doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre résumé peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "La résumé ne doit pas être vide")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(
     * min = "16",
     * max = "100",
     * minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre description peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "La description ne doit pas être vide")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=300, nullable=true)
     * @Assert\Length(
     * min = "6",
     * max = "100",
     * minMessage = "Votre image doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre image peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "La image ne doit pas être vide")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=300, nullable=true)
     * @Assert\Length(
     * min = "6",
     * max = "100",
     * minMessage = "Votre video doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre video peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "La vidéo ne doit pas être vide")
     */
    private $video;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     * @Assert\Choice(choices = {"0", "1", "2"}, message = "Choix non valide")
     */
    private $state;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="view", type="integer", nullable=true)
     */
    private $view;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_active", type="datetime", nullable=true)
     */
    private $dateActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \Jeweler
     *
     * @ORM\ManyToOne(targetEntity="Jeweler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeweler_id", referencedColumnName="id")
     * })
     */
    private $jeweler;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="cms")
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setDefaultValues();
    }

    private function setDefaultValues()
    {
        $this->dateActive   = new \DateTime('now');
        $this->dateCreated  = new \DateTime('now');
        $this->dateUpdated  = new \DateTime('now');
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
     * Set title
     *
     * @param string $title
     * @return Cms
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
     * Set summary
     *
     * @param string $summary
     * @return Cms
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Cms
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
     * @return Cms
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
     * Set video
     *
     * @param string $video
     * @return Cms
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Cms
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Cms
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set view
     *
     * @param integer $view
     * @return Cms
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set dateActive
     *
     * @param \DateTime $dateActive
     * @return Cms
     */
    public function setDateActive($dateActive)
    {
        $this->dateActive = $dateActive;

        return $this;
    }

    /**
     * Get dateActive
     *
     * @return \DateTime 
     */
    public function getDateActive()
    {
        return $this->dateActive;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Cms
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Cms
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
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Cms
     */
    public function setJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler = null)
    {
        $this->jeweler = $jeweler;

        return $this;
    }

    /**
     * Get jeweler
     *
     * @return \Store\BackendBundle\Entity\Jeweler 
     */
    public function getJeweler()
    {
        return $this->jeweler;
    }

    /**
     * Add product
     *
     * @param \Store\BackendBundle\Entity\Product $product
     * @return Cms
     */
    public function addProduct(\Store\BackendBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Store\BackendBundle\Entity\Product $product
     */
    public function removeProduct(\Store\BackendBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Return title
     * @return string
     */
    function __toString()
    {
        return (string)$this->title;
    }


}

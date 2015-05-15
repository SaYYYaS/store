<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Store\BackendBundle\Validator\Constraints as StoreAssert;

/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\CategoryRepository")
 */
class Category
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
     * min = "5",
     * max = "500",
     * minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre titre peut faire au maximum {{ limit }} caractères",
     * groups = {"new", "edit"})
     *
     * @Assert\NotBlank( message = "Le titre ne doit pas être vide", groups = {"new", "edit"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @StoreAssert\StripTagsLength(maxMessage = "Votre chaine de caractère est supérieur à {{ limit }} ",
     * max = "500", groups = {"new", "edit"})
     * @Assert\NotBlank( message = "La description ne doit pas être vide", groups = {"new", "edit"})
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.", groups = {"new", "edit"})
     * @Assert\NotBlank( message = "La position ne peut pas être vide", groups = {"new", "edit"})
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

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
     * @ORM\ManyToMany(targetEntity="Store\BackendBundle\Model\CategorySubjectInterface", mappedBy="category")
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
        $this->active  = true;
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
     * @return Category
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
     * @return Category
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
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Category
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
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Category
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
     * @return Category
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

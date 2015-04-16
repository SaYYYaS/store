<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Store\BackendBundle\Validator\Constraints as StoreAssert;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\ProductRepository")
 * @UniqueEntity(fields = "ref", message = "Votre référence de bijoux éxiste déjà")
 * @UniqueEntity(fields = "title", message = "Votre titre de bijoux existe déjà")
 */
class Product
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
     * @Assert\NotBlank( message = "La référence ne doit pas être vide")
     * @Assert\Regex( pattern = "/([A-Z]{4}-[0-9]{2}-[A-Z]{1}|[A-Z]{2}[0-9]{2})/" , message = "La référence doit être valide")
     *
     * @ORM\Column(name="ref", type="string", length=30, nullable=true)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150, nullable=true)
     * @Assert\Length(
     * min = "4",
     * max = "200",
     * minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre titre peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "Le titre ne doit pas être vide")
     * @Assert\Regex( pattern = "/[\w\d\s]{4,200}/", message = "Votre titre n'est pas valide")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     * @StoreAssert\StripTagsLength(
     * min = "4",
     * max = "200",
     * minMessage = "Votre résumé doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre résumé peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "Le résumé ne doit pas être vide")
     * @Assert\Regex( pattern = "/[\w\d\s]{4,10}/", message = "Votre résumé n'est pas valide")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @StoreAssert\StripTagsLength(
     * min = "4",
     * max = "500",
     * minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre description peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "Le description ne doit pas être vide")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="composition", type="text", nullable=true)
     * @StoreAssert\StripTagsLength(
     * min = "10",
     * max = "400",
     * minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre description peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "Le description ne doit pas être vide")
     * @Assert\Regex( pattern = "/[\w\d\s]{4,15}/", message = "Votre description n'est pas valide")
     */
    private $composition;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     * @Assert\Range(
     * min = 5,
     * max = 100000,
     * minMessage = "Votre bijou doit faire au moins {{ limit }} €",
     * maxMessage = "Votre bijou peut valoir au maximum {{ limit }} €")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="taxe", type="float", precision=10, scale=0, nullable=true)
     * @Assert\Choice(choices = {"5.5", "19.6", "20"}, message = "Choix non valide")
     */
    private $taxe;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     * @Assert\Range(min = 1, max = 200, minMessage = "Au moins {{ limit }} produit", maxMessage = "Maximum produit autorisé : {{ limit }}")
     */
    private $quantity;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_active", type="datetime", nullable=true)
     */
    private $dateActive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cover", type="boolean", nullable=true)
     */
    private $cover;

    /**
     * @var boolean
     *
     * @ORM\Column(name="shop", type="boolean", nullable=true)
     */
    private $shop;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=300, nullable=true)
     * @Assert\Length(
     * min = "4",
     * max = "100",
     * minMessage = "Votre slug doit faire au moins {{ limit }} caractères",
     * maxMessage = "Votre slug peut faire au maximum {{ limit }} caractères")
     *
     * @Assert\NotBlank( message = "Le slug ne doit pas être vide")
     * @Assert\Regex( pattern = "/[\d\-\_]{4,100}/", message = "Votre slug n'est pas valide")
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $dateUpdated;

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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="product")
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Orders", mappedBy="product")
     */
    private $order;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Business", inversedBy="product")
     * @ORM\JoinTable(name="product_business",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="business_id", referencedColumnName="id")
     *   }
     * )
     */
    private $business;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="product")
     * @ORM\JoinTable(name="product_category",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     * @Assert\Count(
     * min = "1",
     * max = "10",
     * minMessage = " Au moins {{ limit }} catégorie",
     * maxMessage = " Pas plus de {{ limit }} catégories"
     * )
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Cms", inversedBy="product")
     * @ORM\JoinTable(name="product_cms",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="cms_id", referencedColumnName="id")
     *   }
     * )
     * @Assert\Count(
     * min = "1",
     * max = "10",
     * minMessage = " Au moins {{ limit }} page",
     * maxMessage = " Pas plus de {{ limit }} pages"
     * )
     */
    private $cms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     **/
    private $image;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="product")
     * @ORM\JoinTable(name="product_featured",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="product2_id", referencedColumnName="id")
     *   }
     * )
     */
    private $product2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Supplier", inversedBy="product")
     * @ORM\JoinTable(name="product_supplier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     *   }
     * )
     */
    private $supplier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="product")
     * @ORM\JoinTable(name="product_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user        = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order       = new \Doctrine\Common\Collections\ArrayCollection();
        $this->business    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cms         = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product2    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supplier    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag         = new \Doctrine\Common\Collections\ArrayCollection();
        $this->image       = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setDefaultValues();
    }

    private function setDefaultValues()
    {
        $this->active      = true;
        $this->cover       = false;
        $this->shop        = true;
        $this->taxe        = 20;
        $this->price       = 0;
        $this->quantity    = 1;
        $this->dateActive  = new \DateTime('now');
        $this->dateActive  = new \DateTime('now');
        $this->dateUpdated = new \DateTime('now');

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
     * Set ref
     *
     * @param string $ref
     * @return Product
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
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
     * @param \Doctrine\Common\Collections\Collection $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set summary
     *
     * @param string $summary
     * @return Product
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
     * @return Product
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
     * Set composition
     *
     * @param string $composition
     * @return Product
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string 
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set taxe
     *
     * @param float $taxe
     * @return Product
     */
    public function setTaxe($taxe)
    {
        $this->taxe = $taxe;

        return $this;
    }

    /**
     * Get taxe
     *
     * @return float 
     */
    public function getTaxe()
    {
        return $this->taxe;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Product
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
     * Set dateActive
     *
     * @param \DateTime $dateActive
     * @return Product
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
     * Set cover
     *
     * @param boolean $cover
     * @return Product
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return boolean 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set shop
     *
     * @param boolean $shop
     * @return Product
     */
    public function setShop($shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop
     *
     * @return boolean 
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Product
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
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Product
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
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Product
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
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Product
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
     * Add user
     *
     * @param \Store\BackendBundle\Entity\User $user
     * @return Product
     */
    public function addUser(\Store\BackendBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Store\BackendBundle\Entity\User $user
     */
    public function removeUser(\Store\BackendBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add order
     *
     * @param \Store\BackendBundle\Entity\Orders $order
     * @return Product
     */
    public function addOrder(\Store\BackendBundle\Entity\Orders $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Store\BackendBundle\Entity\Orders $order
     */
    public function removeOrder(\Store\BackendBundle\Entity\Orders $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add business
     *
     * @param \Store\BackendBundle\Entity\Business $business
     * @return Product
     */
    public function addBusiness(\Store\BackendBundle\Entity\Business $business)
    {
        $this->business[] = $business;

        return $this;
    }

    /**
     * Remove business
     *
     * @param \Store\BackendBundle\Entity\Business $business
     */
    public function removeBusiness(\Store\BackendBundle\Entity\Business $business)
    {
        $this->business->removeElement($business);
    }

    /**
     * Get business
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * Add category
     *
     * @param \Store\BackendBundle\Entity\Category $category
     * @return Product
     */
    public function addCategory(\Store\BackendBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Store\BackendBundle\Entity\Category $category
     */
    public function removeCategory(\Store\BackendBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add cms
     *
     * @param \Store\BackendBundle\Entity\Cms $cms
     * @return Product
     */
    public function addCm(\Store\BackendBundle\Entity\Cms $cms)
    {
        $this->cms[] = $cms;

        return $this;
    }

    /**
     * Remove cms
     *
     * @param \Store\BackendBundle\Entity\Cms $cms
     */
    public function removeCm(\Store\BackendBundle\Entity\Cms $cms)
    {
        $this->cms->removeElement($cms);
    }

    /**
     * Get cms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCms()
    {
        return $this->cms;
    }

    /**
     * Add product2
     *
     * @param \Store\BackendBundle\Entity\Product $product2
     * @return Product
     */
    public function addProduct2(\Store\BackendBundle\Entity\Product $product2)
    {
        $this->product2[] = $product2;

        return $this;
    }

    /**
     * Remove product2
     *
     * @param \Store\BackendBundle\Entity\Product $product2
     */
    public function removeProduct2(\Store\BackendBundle\Entity\Product $product2)
    {
        $this->product2->removeElement($product2);
    }

    /**
     * Get product2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct2()
    {
        return $this->product2;
    }

    /**
     * Add supplier
     *
     * @param \Store\BackendBundle\Entity\Supplier $supplier
     * @return Product
     */
    public function addSupplier(\Store\BackendBundle\Entity\Supplier $supplier)
    {
        $this->supplier[] = $supplier;

        return $this;
    }

    /**
     * Remove supplier
     *
     * @param \Store\BackendBundle\Entity\Supplier $supplier
     */
    public function removeSupplier(\Store\BackendBundle\Entity\Supplier $supplier)
    {
        $this->supplier->removeElement($supplier);
    }

    /**
     * Get supplier
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Add tag
     *
     * @param \Store\BackendBundle\Entity\Tag $tag
     * @return Product
     */
    public function addTag(\Store\BackendBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Store\BackendBundle\Entity\Tag $tag
     */
    public function removeTag(\Store\BackendBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
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

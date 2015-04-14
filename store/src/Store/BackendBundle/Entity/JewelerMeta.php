<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JewelerMeta
 *
 * @ORM\Table(name="jeweler_meta", indexes={@ORM\Index(name="jeweler_id", columns={"jeweler_id"})})
 * @ORM\Entity
 */
class JewelerMeta
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
     * @ORM\Column(name="city", type="string", length=300, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=300, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=300, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="retour", type="text", nullable=true)
     */
    private $retour;

    /**
     * @var string
     *
     * @ORM\Column(name="propos", type="text", nullable=true)
     */
    private $propos;

    /**
     * @var string
     *
     * @ORM\Column(name="delai", type="text", nullable=true)
     */
    private $delai;

    /**
     * @var float
     *
     * @ORM\Column(name="longituide", type="float", precision=10, scale=0, nullable=true)
     */
    private $longituide;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="optin", type="boolean", nullable=true)
     */
    private $optin;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_activity", type="integer", nullable=true)
     */
    private $lastActivity;

    /**
     * @var string
     *
     * @ORM\Column(name="mention", type="text", nullable=true)
     */
    private $mention;

    /**
     * @var string
     *
     * @ORM\Column(name="expedition", type="text", nullable=true)
     */
    private $expedition;

    /**
     * @var string
     *
     * @ORM\Column(name="dawanda", type="string", length=300, nullable=true)
     */
    private $dawanda;

    /**
     * @var string
     *
     * @ORM\Column(name="littlemarket", type="string", length=300, nullable=true)
     */
    private $littlemarket;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return JewelerMeta
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return JewelerMeta
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return JewelerMeta
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
     * Set website
     *
     * @param string $website
     * @return JewelerMeta
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set retour
     *
     * @param string $retour
     * @return JewelerMeta
     */
    public function setRetour($retour)
    {
        $this->retour = $retour;

        return $this;
    }

    /**
     * Get retour
     *
     * @return string 
     */
    public function getRetour()
    {
        return $this->retour;
    }

    /**
     * Set propos
     *
     * @param string $propos
     * @return JewelerMeta
     */
    public function setPropos($propos)
    {
        $this->propos = $propos;

        return $this;
    }

    /**
     * Get propos
     *
     * @return string 
     */
    public function getPropos()
    {
        return $this->propos;
    }

    /**
     * Set delai
     *
     * @param string $delai
     * @return JewelerMeta
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return string 
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Set longituide
     *
     * @param float $longituide
     * @return JewelerMeta
     */
    public function setLongituide($longituide)
    {
        $this->longituide = $longituide;

        return $this;
    }

    /**
     * Get longituide
     *
     * @return float 
     */
    public function getLongituide()
    {
        return $this->longituide;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return JewelerMeta
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set optin
     *
     * @param boolean $optin
     * @return JewelerMeta
     */
    public function setOptin($optin)
    {
        $this->optin = $optin;

        return $this;
    }

    /**
     * Get optin
     *
     * @return boolean 
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * Set lastActivity
     *
     * @param integer $lastActivity
     * @return JewelerMeta
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return integer 
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * Set mention
     *
     * @param string $mention
     * @return JewelerMeta
     */
    public function setMention($mention)
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * Get mention
     *
     * @return string 
     */
    public function getMention()
    {
        return $this->mention;
    }

    /**
     * Set expedition
     *
     * @param string $expedition
     * @return JewelerMeta
     */
    public function setExpedition($expedition)
    {
        $this->expedition = $expedition;

        return $this;
    }

    /**
     * Get expedition
     *
     * @return string 
     */
    public function getExpedition()
    {
        return $this->expedition;
    }

    /**
     * Set dawanda
     *
     * @param string $dawanda
     * @return JewelerMeta
     */
    public function setDawanda($dawanda)
    {
        $this->dawanda = $dawanda;

        return $this;
    }

    /**
     * Get dawanda
     *
     * @return string 
     */
    public function getDawanda()
    {
        return $this->dawanda;
    }

    /**
     * Set littlemarket
     *
     * @param string $littlemarket
     * @return JewelerMeta
     */
    public function setLittlemarket($littlemarket)
    {
        $this->littlemarket = $littlemarket;

        return $this;
    }

    /**
     * Get littlemarket
     *
     * @return string 
     */
    public function getLittlemarket()
    {
        return $this->littlemarket;
    }

    /**
     * Set jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return JewelerMeta
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
    * Return id
    * @return string
    */
    function __toString()
    {
        return (string)$this->id;
    }
}

<?php

namespace Richpolis\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tracks
 *
 * @ORM\Table(name="discos_tracks")
 * @ORM\Entity(repositoryClass="Richpolis\FrontendBundle\Repository\TracksRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tracks
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="track", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $track;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean",nullable=false)
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", length=1)
     */
    private $posicion;
    
    /**
     * @var \Discos
     *
     * @ORM\ManyToOne(targetEntity="Discos", inversedBy="tracks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="disco_id", referencedColumnName="id")
     * })
     */
    private $disco;


    public function __construct() {
        $this->isActive=true;
    }
    
    public function __toString() {
        return $this->getTrack();
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Tracks
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set disco
     *
     * @param \Richpolis\FrontendBundle\Entity\Discos $disco
     * @return Tracks
     */
    public function setDisco(\Richpolis\FrontendBundle\Entity\Discos $disco = null)
    {
        $this->disco = $disco;
    
        return $this;
    }

    /**
     * Get disco
     *
     * @return \Richpolis\FrontendBundle\Entity\Discos 
     */
    public function getDisco()
    {
        return $this->disco;
    }
    
    
    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return Tracks
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set track
     *
     * @param string $track
     *
     * @return Tracks
     */
    public function setTrack($track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get track
     *
     * @return string 
     */
    public function getTrack()
    {
        return $this->track;
    }
}

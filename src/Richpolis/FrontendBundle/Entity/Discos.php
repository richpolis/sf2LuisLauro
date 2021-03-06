<?php

namespace Richpolis\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Discos
 *
 * @ORM\Table(name="discos")
 * @ORM\Entity(repositoryClass="Richpolis\FrontendBundle\Repository\DiscosRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Discos
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
     * @ORM\Column(name="disco", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $disco;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_es", type="text",nullable=true)
     */
    private $descripcionEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_en", type="text",nullable=true)
     */
    private $descripcionEn;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255,nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="link_apple_store", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $linkAppleStore;
    
    /**
     * @var string
     *
     * @ORM\Column(name="link_sound_cloud", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $linkSoundCloud;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    
    /**
     * @ORM\OneToMany(targetEntity="Tracks", mappedBy="disco")
     */
    private $tracks;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", length=1)
     */
    private $posicion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime",nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     */
    private $updatedAt;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tracks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->isActive = true;
    }
    
    /*
     * Nombre de la disco
     */
    public function __toString() {
        return $this->getDisco();
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
     * Set disco
     *
     * @param string $disco
     * @return Discos
     */
    public function setDisco($disco)
    {
        $this->disco = $disco;
    
        return $this;
    }

    /**
     * Get disco
     *
     * @return string 
     */
    public function getDisco()
    {
        return $this->disco;
    }

    /**
     * Set descripcion, segun el locale de la aplicacion 
     *
     * @param string $descripcion
     * @return Discos
     */
    public function setDescripcion($locale,$descripcion)
    {
        if($locale=="es"){
            $this->descripcionEs = $descripcion;
        }else{
            $this->descripcionEn = $descripcion;
        }
    
        return $this;
    }

    /**
     * Get descripcion, segun el locale de la aplicacion
     *
     * @return string 
     */
    public function getDescripcion($locale)
    {
        if($locale=="es"){
            return $this->descripcionEs;
        }else{
            return $this->descripcionEn;
        }
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Discos
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    
        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Discos
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
     * Set slug
     *
     * @param string $slug
     * @return Discos
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Discos
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Discos
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add tracks
     *
     * @param \Richpolis\FrontendBundle\Entity\Tracks $tracks
     * @return Discos
     */
    public function addTrack(\Richpolis\FrontendBundle\Entity\Tracks $tracks)
    {
        $this->tracks[] = $tracks;
    
        return $this;
    }

    /**
     * Remove tracks
     *
     * @param \Richpolis\FrontendBundle\Entity\Tracks $tracks
     */
    public function removeTrack(\Richpolis\FrontendBundle\Entity\Tracks $tracks)
    {
        $this->tracks->removeElement($tracks);
    }

    /**
     * Get tracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTracks()
    {
        return $this->tracks;
    }
    
    /*
     * Slugable
     */
    
    /**
    * @ORM\PrePersist
    */
    public function setSlugAtValue()
    {
        $this->slug = \Richpolis\BackendBundle\Utils\Richsys::slugify($this->getDisco());
    }
    
    
    /*
     * Timestable
     */
    
    /**
     ** @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
          $this->createdAt = new \DateTime();
        }
        if(!$this->getUpdatedAt())
        {
          $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /*** uploads ***/
    
    public $file;
    
   /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->file) {
        // do whatever you want to generate a unique name
        $this->imagen       =   uniqid().'.'.$this->file->guessExtension();
      }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null === $this->file) {
        return;
      }

      // if there is an error when moving the file, an exception will
      // be automatically thrown by move(). This will properly prevent
      // the entity from being persisted to the database on error
      $this->file->move($this->getUploadRootDir(), $this->imagen);

      unset($this->file);
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        if(file_exists($file)){
            unlink($file);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/discos';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    public function getWebPath()
    {
       return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }

    /**
     * Set descripcionEs
     *
     * @param string $descripcionEs
     * @return Discos
     */
    public function setDescripcionEs($descripcionEs)
    {
        $this->descripcionEs = $descripcionEs;

        return $this;
    }

    /**
     * Get descripcionEs
     *
     * @return string 
     */
    public function getDescripcionEs()
    {
        return $this->descripcionEs;
    }

    /**
     * Set descripcionEn
     *
     * @param string $descripcionEn
     * @return Discos
     */
    public function setDescripcionEn($descripcionEn)
    {
        $this->descripcionEn = $descripcionEn;

        return $this;
    }

    /**
     * Get descripcionEn
     *
     * @return string 
     */
    public function getDescripcionEn()
    {
        return $this->descripcionEn;
    }

    /**
     * Set linkAppleStore
     *
     * @param string $linkAppleStore
     *
     * @return Discos
     */
    public function setLinkAppleStore($linkAppleStore)
    {
        $this->linkAppleStore = $linkAppleStore;

        return $this;
    }

    /**
     * Get linkAppleStore
     *
     * @return string 
     */
    public function getLinkAppleStore()
    {
        return $this->linkAppleStore;
    }

    /**
     * Set linkSoundCloud
     *
     * @param string $linkSoundCloud
     *
     * @return Discos
     */
    public function setLinkSoundCloud($linkSoundCloud)
    {
        $this->linkSoundCloud = $linkSoundCloud;

        return $this;
    }

    /**
     * Get linkSoundCloud
     *
     * @return string 
     */
    public function getLinkSoundCloud()
    {
        return $this->linkSoundCloud;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return Discos
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
    
    
}

<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Publicacion
 *
 * @ORM\Table(name="publicacion")
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Repository\PublicacionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Publicacion
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
     * @ORM\Column(name="titulo_es", type="string", length=255 )
     * @Assert\NotBlank()
     */
    private $tituloEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titulo_en", type="string", length=255 )
     * @Assert\NotBlank()
     */
    private $tituloEn;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_es", type="text" )
     * @Assert\NotBlank()
     */
    private $descripcionEs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_en", type="text" )
     * @Assert\NotBlank()
     */
    private $descripcionEn;
    
    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true )
     */
    private $archivo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true )
     */
    private $thumbnail;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", nullable=false )
     */
    private $posicion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true )
     */
    private $isActive;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var \CategoriasPublicacion
     *
     * @ORM\ManyToOne(targetEntity="CategoriasPublicacion", inversedBy="publicaciones" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;
    
    public function __construct() {
       $this->isActive = true;
    }
    
    public function __toString() {
        return $this->getTitulo();
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
     * Set titulo
     *
     * @param string $titulo
     * @param string $locale 
     * @return Publicacion
     */
    public function setTitulo($titulo,$locale)
    {
        if($locale == "es"){
            $this->tituloEs = $titulo;
        }else{
            $this->tituloEn = $titulo;
        }
        
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo($locale)
    {
        if($locale == "es"){
            $titulo = $this->tituloEs;
        }else{
            $titulo = $this->tituloEn;
        }
        return $titulo;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Publicacion
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
     * Set slug
     *
     * @param string $slug
     * @return Publicacion
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Publicacion
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Publicacion
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
     * @return Publicacion
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
     * Set categoria
     *
     * @param \Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion $categoria
     * @return Publicacion
     */
    public function setCategoria(\Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /*
     * Slugable
     */
    
    /**
    * @ORM\PrePersist
    */
    public function setSlugAtValue()
    {
        $this->slug = RpsStms::slugify($this->getTituloEn());
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
    
    
    /**
     * Regresa el titulo corto segun el maximo de caracteres solicitado
     * 
     * @return string
     * 
     */
    
    public function getTituloCorto($max=15){
        if($this->titulo)
            return substr($this->getTituloEn(), 0, $max);
        else
            return "Sin titulo";
    }
    
    

    public function getDescripcionHtml(){
       $traduce=array('Á'=>'&Aacute;',
                    'á'=>'&aacute;',
                    'É'=>'&Eacute;',
                    'é'=>'&eacute;',
                    'Í'=>'&Iacute;',
                    'í'=>'&iacute;',
                    'Ó'=>'&Oacute;',
                    'ó'=>'&oacute;',
                    'Ú'=>'&Uacute;',
                    'ú'=>'&uacute;',
                    'Ü'=>'&Uuml;',
                    'ü'=>'&uuml;',
                    'Ṅ'=>'&Ntilde;',
                    'ñ'=>'&ntilde;',
                    '&'=>'&amp;',
                    '<'=>'&lt;',
                    '>'=>'&gt;',
                    "'"=>"\'");
       $sale=strtr( $this->getDescripcion() , $traduce );
       return $sale;

    }
   

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Publicacion
     */
    public function setDescripcion($descripcion,$locale)
    {
        if($locale == "es"){
            $this->descripcionEs = $descripcion;
        }else{
            $this->descripcionEn = $descripcion;
        }
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion($locale)
    {
        if($locale == "es"){
            $descripcion = $this->descripcionEs;
        }else{
            $descripcion = $this->descripcionEn;
        }
        return $descripcion;
    }

    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    public function crearThumbnail(){
        $imagine= new \Imagine\Gd\Imagine();
        $mode= \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        $size=new \Imagine\Image\Box($this->getWidth(),$this->getHeight());
        $this->thumbnail=$this->archivo;
        
        $imagine->open($this->getAbsolutePath())
                ->thumbnail($size, $mode)
                ->save($this->getAbosluteThumbnailPath());
        
    }
    
    /*** links videos ***/
    
    public $linkVideo;
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preSaveGaleria()
    {
      if (null !== $this->linkVideo) {  
        $tipoArchivo= RpsStms::getTipoArchivo($this->linkVideo);
        
        if(!(null === $this->archivo)){
            $this->removeUpload();
        }
        
        if ($tipoArchivo == RpsStms::$TIPO_ARCHIVO_LINK) {
          $infoVideo=  \Richpolis\BackendBundle\Utils\Richsys::getTitleAndImageVideoYoutube($this->linkVideo);
          $this->setThumbnail($infoVideo['thumbnail']);
          $this->setArchivo($infoVideo['urlVideo']);
        }
      }
    }
    
    
    public function getTipoArchivo(){
        return RpsStms::getTipoArchivo($this->getArchivo());
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
        $this->archivo       =   uniqid().'.'.$this->file->guessExtension();
        $this->thumbnail    =   $this->archivo;
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
      $this->file->move($this->getUploadRootDir(), $this->archivo);

      $this->crearThumbnail();
      
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
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
    }
    
    protected function getUploadDir()
    {
        return '/uploads/publicaciones';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    protected function getThumbnailRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir().'/thumbnails';
    }
        
    public function getWebPath()
    {
        return null === $this->archivo ? null : $this->getUploadDir().'/'.$this->archivo;
    }

    public function getThumbnailWebPath()
    {
        if($this->getIsImagen()){
            if(!$this->thumbnail){
                if(!file_exists($this->getAbosluteThumbnailPath()) && file_exists($this->getAbsolutePath())){
                    $this->crearThumbnail();
                }
            }
            return null === $this->thumbnail ? null : $this->getUploadDir().'/thumbnails/'.$this->thumbnail;
        }else{
            return $this->getThumbnail();
        }
    }
    
    public function getAbsolutePath()
    {
        return null === $this->archivo ? null : $this->getUploadRootDir().'/'.$this->archivo;
    }
    
    public function getAbosluteThumbnailPath(){
        return null === $this->thumbnail ? null : $this->getUploadRootDir().'/thumbnails/'.$this->thumbnail;
    }
    
    public function actualizaThumbnail()
    {
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
      $this->crearThumbnail();
    }
    
    public function getArchivoView(){
        $opciones=array(
            'tipo_archivo'  => $this->getTipoArchivo(),
            'archivo'   =>  $this->getArchivo(),
            'carpeta'   =>  'publicaciones',
            'width'     =>  $this->getWidth(),
            'height'    =>  $this->getHeight(),
        );
        
        return RpsStms::getArchivoView($opciones);
    }
    
    public function getWidth(){
        return 493;
    }
    
    public function getHeight(){
        return 269;
    }
    
    public function getIsImagen(){
        return (RpsStms::getTipoArchivo($this->getArchivo())==RpsStms::$TIPO_ARCHIVO_IMAGEN);
    }
    

    

    /**
     * Set tituloEs
     *
     * @param string $tituloEs
     *
     * @return Publicacion
     */
    public function setTituloEs($tituloEs)
    {
        $this->tituloEs = $tituloEs;

        return $this;
    }

    /**
     * Get tituloEs
     *
     * @return string 
     */
    public function getTituloEs()
    {
        return $this->tituloEs;
    }

    /**
     * Set tituloEn
     *
     * @param string $tituloEn
     *
     * @return Publicacion
     */
    public function setTituloEn($tituloEn)
    {
        $this->tituloEn = $tituloEn;

        return $this;
    }

    /**
     * Get tituloEn
     *
     * @return string 
     */
    public function getTituloEn()
    {
        return $this->tituloEn;
    }

    /**
     * Set descripcionEs
     *
     * @param string $descripcionEs
     *
     * @return Publicacion
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
     *
     * @return Publicacion
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
     * Set archivo
     *
     * @param string $archivo
     *
     * @return Publicacion
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string 
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Publicacion
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}

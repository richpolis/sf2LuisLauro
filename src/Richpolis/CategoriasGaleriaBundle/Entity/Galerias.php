<?php

namespace Richpolis\CategoriasGaleriaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Galerias
 *
 * @ORM\Table(name="galerias")
 * @ORM\Entity(repositoryClass="Richpolis\CategoriasGaleriaBundle\Repository\GaleriasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Galerias
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
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $archivo;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_archivo", type="integer", length=1)
     */
    private $tipoArchivo;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer", length=1)
     */
    private $posicion;
    
    

     /**
     * @var \Categorias
     *
     * @ORM\ManyToOne(targetEntity="Categorias", inversedBy="galerias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;
    
    public function getStringTipoArchivo(){
        return RpsStms::$sTipoArchivo[$this->getTipoArchivo()];
    }

    static function getArrayTipoArchivos(){
        return RpsStms::$sTipoArchivos;
    }

    static function getPreferedTipoArchivo(){
        return array(RpsStms::$TIPO_ARCHIVO_IMAGEN);
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
     * @return Galerias
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Galerias
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Galerias
     */
    public function setTipoArchivo($tipoArchivo)
    {
        $this->tipoArchivo = $tipoArchivo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipoArchivo()
    {
        return $this->tipoArchivo;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Galerias
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
     * Set archivo
     *
     * @param string $archivo
     * @return Galerias
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
     * @return Galerias
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

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return Galerias
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Galerias
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
     * Set categoria
     *
     * @param \Richpolis\CategoriasGaleriaBundle\Entity\Categorias $categoria
     * @return Galerias
     */
    public function setCategoria(\Richpolis\CategoriasGaleriaBundle\Entity\Categorias $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return \Richpolis\CategoriasGaleriaBundle\Entity\Categorias 
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
    * @ORM\PreUpdate
    */
    public function setSlugAtValue()
    {
        $this->slug = RpsStms::slugify($this->getTitulo());
    }
    
    /**
     * Regresa el titulo corto segun el maximo de caracteres solicitado
     * 
     * @return string
     * 
     */
    
    public function getTituloCorto($max=15){
        if($this->titulo)
            return substr($this->getTitulo(), 0, $max);
        else
            return "Sin titulo";
    }
    
    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    public function crearThumbnail(){
        if($this->getIsImagen()){
            $imagine= new \Imagine\Gd\Imagine();
            $mode= \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
            $size=new \Imagine\Image\Box($this->getWidth(),$this->getHeight());
            $this->thumbnail=$this->archivo;

            $imagine->open($this->getAbsolutePath())
                    ->thumbnail($size, $mode)
                    ->save($this->getAbosluteThumbnailPath());
        }
    }
    
    
    /*
     * Para guardar videos de youtube o vimeo
     * 
     */
    
   /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preSaveGaleria()
    {
      if ($this->getIsLink()) {
        $infoVideo= RpsStms::getTitleAndImageVideoYoutube($this->getArchivo());
        $this->setThumbnail($infoVideo['thumbnail']);
        $this->setArchivo($infoVideo['urlVideo']);
        $this->setTitulo($infoVideo['title']);
        $this->setDescripcion($infoVideo['description']);
      }
    }

    
    /*** uploads ***/
    
    public $file;
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->archivo)) {
            // store the old name to delete after the update
            $this->temp = $this->archivo;
            $this->archivo = null;
        } else {
            $this->archivo = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public $fileTmb;
    
    /**
     * Sets fileTmb.
     *
     * @param UploadedFile $fileTmb
     */
    public function setFileTmb(UploadedFile $fileTmb = null)
    {
        $this->fileTmb = $fileTmb;
        // check if we have an old image path
        if (isset($this->thumbnail)) {
            // store the old name to delete after the update
            $this->tempTmb = $this->thumbnail;
            $this->thumbnail = null;
        } else {
            $this->thumbnail = 'initial';
        }
    }

    /**
     * Get fileTmb.
     *
     * @return UploadedFile
     */
    public function getFileTmb()
    {
        return $this->fileTmb;
    }
    
   /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->getFile()) {
        // do whatever you want to generate a unique name
        $this->archivo = uniqid().'.'.$this->getFile()->guessExtension();
      }
      
      if (null !== $this->getFileTmb()) {
        // do whatever you want to generate a unique name
        $this->thumbnail = uniqid().'.'.$this->getFileTmb()->guessExtension();
      }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null !== $this->getFile()) {
        // mover el archivo al path
        $this->getFile()->move($this->getUploadRootDir(), $this->archivo);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;

        $this->crearThumbnail();
      }
      
      if (null !== $this->getFileTmb()) {
        // subir la portada al path
        $this->getFileTmb()->move($this->getThumbnailRootDir(), $this->thumbnail);

        // check if we have an old image
        if (isset($this->tempTmb)) {
            // delete the old image
            unlink($this->getThumbnailRootDir().'/'.$this->tempTmb);
            // clear the temp image path
            $this->tempTmb = null;
        }
        $this->fileTmb = null;
      }
      
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
        return '/uploads/galerias';
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
        if($this->getIsImagen()){
            return null === $this->archivo ? null : $this->getUploadDir().'/'.$this->archivo;
        }elseif($this->getIsLink()){
            return $this->getArchivo();
        }else{
            return null === $this->archivo ? null : $this->getUploadDir().'/'.$this->archivo;
        }
    }

    public function getThumbnailWebPath()
    {
        if($this->getIsImagen()){
            if(!$this->thumbnail){
                if(!file_exists($this->getAbosluteThumbnailPath()) && file_exists($this->getAbsolutePath())){
                    $this->crearThumbnail();
                }
            }
            $ref= null;
        }elseif($this->getIsLink()){
            return $this->getThumbnail();  //adios, este no hay archivo
        }elseif($this->getIsMusica()){
            $ref = $this->getUploadDir().'/ico_musica.png';
        }elseif($this->getIsVideo()){
            $ref = $this->getUploadDir().'/ico_video.png';
        }
        return null === $this->thumbnail ? $ref : $this->getUploadDir().'/thumbnails/'.$this->thumbnail;
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
            'tipo_archivo'  => RpsStms::getTipoArchivo($this->getArchivo()),
            'archivo'   =>  $this->getArchivo(),
            'carpeta'   =>  'galerias',
            'width'     =>  700,
            'height'    =>  370,
        );
        
        return RpsStms::getArchivoView($opciones);
    }
    
    public function getArchivoArtistasView(){
        $opciones=array(
            'tipo_archivo'  => RpsStms::getTipoArchivo($this->getArchivo()),
            'archivo'   =>  $this->getArchivo(),
            'carpeta'   =>  'galerias',
            'width'     =>  365,
            'height'    =>  300,
        );
        
        return RpsStms::getArchivoView($opciones);
    }
    
    public function getArchivoProductosView(){
        $opciones=array(
            'tipo_archivo'  => RpsStms::getTipoArchivo($this->getArchivo()),
            'archivo'   =>  $this->getArchivo(),
            'carpeta'   =>  'galerias',
            'width'     =>  510,
            'height'    =>  300,
        );
        
        return RpsStms::getArchivoView($opciones);
    }
    
    public function getWidth(){
       /*switch($this->getCategoria()->getTipoCategoria()){
            case Categorias::$GALERIA_NOTICIAS: 
                $resp= 222;
                break;
            case Categorias::$GALERIA_ARTISTAS:
                $resp= 284;
                break;
            default :
                $resp= 221;
                break;
            
        }
        return $resp;*/
        return 120;
    }
    public function getHeight(){
        /*switch($this->getCategoria()->getTipoCategoria()){
            case Categorias::$GALERIA_NOTICIAS: 
                $resp= 167;
                break;
            case Categorias::$GALERIA_ARTISTAS:
                $resp= 213;
                break;
            default :
                $resp= 144;
                break;
        }
        return $resp;*/
        return 100;
    }

    public function getIsImagen(){
        if($this->getTipoArchivo()==RpsStms::$TIPO_ARCHIVO_IMAGEN)
            return true;
        else
            return false;
    }
    
    public function getIsVideo(){
        if($this->getTipoArchivo()==RpsStms::$TIPO_ARCHIVO_VIDEO)
            return true;
        else
            return false;
    }
    
    public function getIsMusica(){
        if($this->getTipoArchivo()==RpsStms::$TIPO_ARCHIVO_MUSICA)
            return true;
        else
            return false;
    }
    
    public function getIsLink(){
        if($this->getTipoArchivo()==RpsStms::$TIPO_ARCHIVO_LINK)
            return true;
        else
            return false;
    }

    public function getTipoMimeAudioVideo(){
        return RpsStms::getTipoMimeAudioVideo($this->getArchivo());
    }
}

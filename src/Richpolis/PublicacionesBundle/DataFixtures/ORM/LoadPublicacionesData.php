<?php


namespace Richpolis\PublicacionesBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Richpolis\PublicacionesBundle\Entity\CategoriasPublicacion;
 
class LoadPublicacionesData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $noticias = new CategoriasPublicacion();
    $noticias->setCategoria('Noticias');
    $noticias->setTipoCategoria(CategoriasPublicacion::$NOTICIAS);
    $noticias->setPosicion(1);
    
    $blog = new CategoriasPublicacion();
    $blog->setCategoria('Blog');
    $blog->setTipoCategoria(CategoriasPublicacion::$BLOG);
    $blog->setPosicion(2);
    
    $biografia = new CategoriasPublicacion();
    $biografia->setCategoria('Biografia');
    $biografia->setTipoCategoria(CategoriasPublicacion::$BIOGRAFIA);
    $biografia->setPosicion(3);
    
    $em->persist($noticias);
    $em->persist($blog);
    $em->persist($biografia);
    
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}
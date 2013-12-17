<?php


namespace Richpolis\FrontendBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Richpolis\FrontendBundle\Entity\Discos;
 
class LoadDiscosData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $amanecer = new Discos();
    $amanecer->setDisco('Amanecer');
    $amanecer->setIsActive(true);
    $amanecer->setPosicion(1);
    
    $galaxy = new Discos();
    $galaxy->setDisco('Galaxy');
    $galaxy->setIsActive(true);
    $galaxy->setPosicion(2);
    
        
    $em->persist($amanecer);
    $em->persist($galaxy);
    $em->flush();
 

  }
 
  public function getOrder()
  {
    return 3; // the order in which fixtures will be loaded
  }
}
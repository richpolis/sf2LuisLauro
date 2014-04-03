<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Richpolis\FrontendBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;


class Usuario
{
    protected $name;

    protected $email;

    protected $telefono;
    
    protected $direccion;
    
    protected $estado;
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    
    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank(array(
            'message' => 'Ingresar su nombre'
        )));
        $metadata->addPropertyConstraint('name', new Length(array(
            'min'        => 2,
            'max'        => 256,
            'minMessage' => 'Your first name must be at least {{ limit }} characters length',
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters length',
        )));
        
        $metadata->addPropertyConstraint('email', new NotBlank(array(
            'message' => 'Ingresar su email'
        )));
        $metadata->addPropertyConstraint('email', new Email(array(
            'message' => 'Ingresar un email correcto'
        )));

        
    }
}
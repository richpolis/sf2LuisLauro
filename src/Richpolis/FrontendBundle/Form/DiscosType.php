<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiscosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('disco')
            ->add('descripcionEn','textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // Skip it if you want to use default theme
                    ),
                    'label'=>'Descripcion Ingles',
                    'required'=>false,
                ))    
            ->add('descripcionEs','textarea', array(
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // Skip it if you want to use default theme
                    ),
                    'label'=>'Descripcion Español',
                    'required'=>false,
                ))
            ->add('file','file',array(
                'label'=>'Portada',
                'required'=>false,
                ))
            ->add('linkAppleStore','url',array(
                'label'=>'Apple Store',
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'iniciar con http://'
                    )
                ))
            ->add('linkSoundCloud','url',array(
                'label'=>'Sound Cloud',
                'required'=>false,
                'attr'=>array(
                    'placeholder'=>'iniciar con http://'
                    )
                ))
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
            ->add('slug','hidden')
            ->add('posicion','hidden')    
            ->add('imagen','hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\FrontendBundle\Entity\Discos'
        ));
    }

    public function getName()
    {
        return 'richpolis_frontendbundle_discostype';
    }
}

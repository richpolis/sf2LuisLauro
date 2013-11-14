<?php

namespace Richpolis\CategoriasGaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Richpolis\CategoriasGaleriaBundle\Repository\CategoriasRepository;


class GaleriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('descripcion','textarea', array(
                'attr' => array(
                   'class' => 'tinymce',
                   'data-theme' => 'advanced' // Skip it if you want to use default theme
                 )))    
            ->add('file','file',array('label'=>'Imagen'))
            ->add('thumbnail','hidden')
            ->add('posicion','hidden')
            ->add('categoria','entity', array(
                'class' => 'CategoriasGaleriaBundle:Categorias',
                'query_builder' => function(CategoriasRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property'  => 'categoria',
                'label'     => 'Categoria',
                'multiple'  => false
            ))
            ->add('tipoArchivo','hidden')
           
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\CategoriasGaleriaBundle\Entity\Galerias'
        ));
    }

    public function getName()
    {
        return 'richpolis_categoriasgaleriabundle_galeriastype';
    }
}

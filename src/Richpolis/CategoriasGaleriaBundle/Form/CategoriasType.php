<?php

namespace Richpolis\CategoriasGaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\CategoriasGaleriaBundle\Entity\Categorias;

class CategoriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoria','text',array('label'=>'Titulo'))
            ->add('descripcion','textarea', array(
                'attr' => array(
                   'class' => 'tinymce',
                   'data-theme' => 'advanced' // Skip it if you want to use default theme
                 )))
            ->add('tipoCategoria','choice',array(
                'label'=>'Tipo',
                'empty_value'=>false,
                'choices'=>Categorias::getArrayTipoCategorias(),
                'preferred_choices'=>Categorias::getPreferedTipoCategoria()
                ))
            ->add('twitter',"hidden")
            ->add('facebook',"hidden")    
            ->add('posicion',"hidden")
            ->add('portada',"hidden")
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
            ->add('isCategoria','hidden')    
            //->add('isCategoria',null,array('label'=>'Categorias?','required'=>false))    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\CategoriasGaleriaBundle\Entity\Categorias'
        ));
    }

    public function getName()
    {
        return 'richpolis_categoriasgaleriabundle_categoriastype';
    }
}

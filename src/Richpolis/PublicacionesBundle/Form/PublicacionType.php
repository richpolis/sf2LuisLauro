<?php

namespace Richpolis\PublicacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\PublicacionesBundle\Entity\Publicacion;
use Richpolis\PublicacionesBundle\Repository\CategoriasPublicacionRepository;

class PublicacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tituloEs','text',array('label'=>'Titulo español'))
            ->add('tituloEn','text',array('label'=>'Titulo ingles'))
            ->add('descripcionEs','textarea', array(
                    'label'=>'Descripcion español',
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // Skip it if you want to use default theme
                    )
                ))
            ->add('descripcionEn','textarea', array(
                    'label'=>'Descripcion ingles',
                    'attr' => array(
                        'class' => 'tinymce',
                        'data-theme' => 'advanced' // Skip it if you want to use default theme
                    )
                ))    
            ->add('categoria','entity', array(
                'class' => 'PublicacionesBundle:CategoriasPublicacion',
                'query_builder' => function(CategoriasPublicacionRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property'  => 'categoria',
                'label'     => 'Categoria',
                'multiple'  => false
            ))
            ->add('file','file',array('label'=>'Imagen','required'=>false))
            ->add('linkVideo','url',array('label'=>'Link de video','required'=>false,'attr'=>array('placeholder'=>'Youtube o Vimeo')))            
            ->add('archivo','hidden')
            ->add('thumbnail','hidden')
            ->add('posicion','hidden')
            ->add('slug','hidden')
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\PublicacionesBundle\Entity\Publicacion'
        ));
    }

    public function getName()
    {
        return 'richpolis_publicacionesbundle_publicaciontype';
    }
}

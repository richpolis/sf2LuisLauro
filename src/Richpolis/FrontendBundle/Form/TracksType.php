<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\FrontendBundle\Repository\DiscosRepository;

class TracksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('track','text',array('label'=>'Canción'))
            ->add('isActive',null,array('label'=>'Activo?','required'=>false))
            ->add('disco','entity', array(
                'class' => 'FrontendBundle:Discos',
                'query_builder' => function(DiscosRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.id', 'ASC');
                },
                'property'  => 'disco',
                'label'     => 'Disco',
                'multiple'  => false
            ))
           ->add('posicion','hidden')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\FrontendBundle\Entity\Tracks'
        ));
    }

    public function getName()
    {
        return 'richpolis_frontendbundle_trackstype';
    }
}

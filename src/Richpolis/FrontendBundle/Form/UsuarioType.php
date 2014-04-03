<?php

namespace Richpolis\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('label'=>'Nombre'))
            ->add('email','email')
            ->add('telefono','text',array('label'=>'Telefono','required'=>false))
            ->add('direccion','text')
            ->add('estado','text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\FrontendBundle\Entity\Usuario'
        ));
    }

    public function getName()
    {
        return 'richpolis_frontendbundle_usuariotype';
    }
}

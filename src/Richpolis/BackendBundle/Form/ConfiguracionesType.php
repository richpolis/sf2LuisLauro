<?php

namespace Richpolis\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Richpolis\BackendBundle\Entity\Configuraciones;

class ConfiguracionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('configuracion')
            ->add('slug','hidden')
            ->add('texto','text')
            ->add('tipoConfiguracion','hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\BackendBundle\Entity\Configuraciones'
        ));
    }

    public function getName()
    {
        return 'richpolis_backendbundle_configuracionestype';
    }
}

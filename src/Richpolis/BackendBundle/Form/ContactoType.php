<?php

namespace Richpolis\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('label'=>'Nombre'))
            ->add('email','email')
            ->add('subject','hidden')
            ->add('telefono','text',array('label'=>'Telefono'))    
            ->add('body','textarea',array('label'=>'Mensaje'))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\BackendBundle\Entity\Contacto'
        ));
    }

    public function getName()
    {
        return 'richpolis_backendbundle_contactotype';
    }
}

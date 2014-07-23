<?php

// src/Acme/DemoBundle/Form/Extension/ImageTypeExtension.php
namespace Richpolis\CategoriasGaleriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AudioType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'audio';
    }

    /**
     * Add the image_path option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('audio_path'));
        $resolver->setOptional(array('mime_type_audio'));
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('audio_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $audioUrl = $accessor->getValue($parentData, $options['audio_path']);
            } else {
                 $audioUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['audio_url'] = $audioUrl;
        }

        if (array_key_exists('mime_type_audio', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $mimeType = $accessor->getValue($parentData, $options['mime_type_audio']);
            } else {
                 $mimeType = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['mime_type'] = $mimeType;
        }
    }

}
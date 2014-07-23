<?php

// src/Acme/DemoBundle/Form/Extension/ImageTypeExtension.php
namespace Richpolis\CategoriasGaleriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'video';
    }

    /**
     * Add the image_path option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('video_path'));
        $resolver->setOptional(array('thumbnail_path'));
        $resolver->setOptional(array('mime_type_video'));
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
        if (array_key_exists('video_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, $options['video_path']);
            } else {
                 $imageUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['video_url'] = $imageUrl;
        }

        if (array_key_exists('thumbnail_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $thumbnailUrl = $accessor->getValue($parentData, $options['thumbnail_path']);
            } else {
                 $thumbnailUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['thumbnail_url'] = $thumbnailUrl;
        }

        if (array_key_exists('mime_type_video', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $mimeType = $accessor->getValue($parentData, $options['mime_type_video']);
            } else {
                 $mimeType = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['mime_type'] = $mimeType;
        }
    }

}
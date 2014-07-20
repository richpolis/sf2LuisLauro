<?php

// src/Acme/DemoBundle/Form/Extension/ImageTypeExtension.php
namespace Richpolis\CategoriasGaleriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagenType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'imagen';
    }

    /**
     * Add the image_path option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('image_path'));
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
        if (array_key_exists('image_path', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $accessor = PropertyAccess::getPropertyAccessor();
                $imageUrl = $accessor->getValue($parentData, $options['image_path']);
            } else {
                 $imageUrl = null;
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['image_url'] = $imageUrl;
        }
    }

}
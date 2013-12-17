<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\FrontendBundle\Entity\Discos;
use Richpolis\FrontendBundle\Form\DiscosType;

/**
 * Discos controller.
 *
 * @Route("/backend/discos")
 */
class DiscosController extends Controller
{
    /**
     * Lists all Discos entities.
     *
     * @Route("/", name="discos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository("FrontendBundle:Discos")
                    ->getQueryDiscosActivas();

        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Creates a new Discos entity.
     *
     * @Route("/", name="discos_create")
     * @Method("POST")
     * @Template("FrontendBundle:Discos:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Discos();
        $form = $this->createForm(new DiscosType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('discos_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Discos entity.
     *
     * @Route("/new", name="discos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Discos();
        $max=$this->getDoctrine()->getRepository('FrontendBundle:Discos')->getMaxPosicion();
        
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }
        
        $form   = $this->createForm(new DiscosType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Discos entity.
     *
     * @Route("/{id}", name="discos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Discos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Discos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Discos entity.
     *
     * @Route("/{id}/edit", name="discos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Discos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Discos entity.');
        }

        $editForm = $this->createForm(new DiscosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Discos entity.
     *
     * @Route("/{id}", name="discos_update")
     * @Method("POST")
     * @Template("FrontendBundle:Discos:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Discos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Discos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DiscosType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('discos_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Discos entity.
     *
     * @Route("/{id}", name="discos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Discos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Discos entity.');
            }

            $tracks = $entity->getTracks();
            if(count($tracks)>0){
            	foreach($tracks as $track){
            		$em->remove($track);
            	}
            	$em->flush();	
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('discos'));
    }

    /**
     * Creates a form to delete a Discos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Subir registro de Discos.
     *
     * @Route("/{id}/up", name="discos_up")
     * @Method("GET")
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroUp = $em->getRepository('FrontendBundle:Discos')->find($id);
        
        if ($registroUp) {
            $registroDown=$em->getRepository('FrontendBundle:Discos')->getRegistroUpOrDown($registroUp,true);
            if ($registroDown) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('discos',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
    
    /**
     * Subir registro de Discos.
     *
     * @Route("/{id}/down", name="discos_down")
     * @Method("GET")
     */
    public function downAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroDown = $em->getRepository('FrontendBundle:Discos')->find($id);
        
        if ($registroDown) {
            $registroUp=$em->getRepository('FrontendBundle:Discos')->getRegistroUpOrDown($registroDown,false);
            if ($registroUp) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('discos',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
}

<?php

namespace Richpolis\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\BackendBundle\Entity\Configuraciones;
use Richpolis\BackendBundle\Form\ConfiguracionesImagenType;
use Richpolis\BackendBundle\Form\ConfiguracionesLinkVideoType;
use Richpolis\BackendBundle\Form\ConfiguracionesTextType;
use Richpolis\BackendBundle\Form\ConfiguracionesStringType;
use Richpolis\BackendBundle\Form\ConfiguracionesType;

use Richpolis\BackendBundle\Utils\qqFileUploader;

/**
 * Configuraciones controller.
 *
 * @Route("/configuraciones")
 */
class ConfiguracionesController extends Controller
{
    /**
     * Lists all Configuraciones entities.
     *
     * @Route("/", name="configuraciones")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->getRepository("BackendBundle:Configuraciones")->getQueryConfiguracionesActivas();

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
     * Seleccionar un tipo de categoria.
     *
     * @Route("/seleccionar", name="configuraciones_select")
     * @Template()
     */
    public function selectAction()
    {
         return array(
                'tipos'  => Configuraciones::getArrayTipoConfiguracion(),
         );
        
    }

    /**
     * Finds and displays a Configuraciones entity.
     *
     * @Route("/{id}/show", name="configuraciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Configuraciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuraciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Configuraciones entity.
     *
     * @Route("/new", name="configuraciones_new")
     * @Template()
     */
    public function newAction()
    {
        $request=$this->getRequest();
        $tipo=$request->query->get('tipo', Configuraciones::$TEXTO_CORTO);
        $entity = new Configuraciones();
        $entity->setTipoConfiguracion($tipo);
        $form   = $this->createFormEspecializado($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Configuraciones entity.
     *
     * @Route("/create", name="configuraciones_create")
     * @Method("POST")
     * @Template("BackendBundle:Configuraciones:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Configuraciones();
        $tipo=$request->query->get("tipo");
        
        $entity->setTipoConfiguracion($tipo);
        $form   = $this->createFormEspecializado($entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('configuraciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Configuraciones entity.
     *
     * @Route("/{id}/edit", name="configuraciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Configuraciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuraciones entity.');
        }
        $editForm   = $this->createFormEspecializado($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Configuraciones entity.
     *
     * @Route("/{id}/update", name="configuraciones_update")
     * @Method("POST")
     * @Template("BackendBundle:Configuraciones:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Configuraciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuraciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createFormEspecializado($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('configuraciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Configuraciones entity.
     *
     * @Route("/{id}/delete", name="configuraciones_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Configuraciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Configuraciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('configuraciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * upload registro a galeria.
     *
     * @Route("/upload/file", name="configuraciones_upload")
     */
    public function uploadAction(){
        
       // list of valid extensions, ex. array("jpeg", "xml", "bmp")
       $allowedExtensions = array("jpeg","png","gif","jpg","mp3");
       // max file size in bytes
       $sizeLimit = 6 * 1024 * 1024;
       $request=$this->get("request");
       $uploader = new qqFileUploader($allowedExtensions, $sizeLimit,$request->server);
       $uploads= $this->container->getParameter('richpolis_uploads');
       $result = $uploader->handleUpload($uploads."/configuraciones/");
       
       // to pass data through iframe you will need to encode all html tags
       /*****************************************************************/
       //$file = $request->getParameter("qqfile");
       $em = $this->getDoctrine()->getManager();
       $anteriores = $em->getRepository('BackendBundle:Configuraciones')->getConfiguracionesPorTipo(Configuraciones::$FILE);
       if(isset($result["success"])){
           $registro = new Configuraciones();
           $registro->setTexto($result["filename"]);
           $registro->setConfiguracion($result["titulo"]);
           $registro->setTipoConfiguracion(Configuraciones::$FILE);
           $em->persist($registro);
           $em->flush();
           $urlEdit = $this->generateUrl('configuraciones_edit',array('id'=>$registro->getId()));
           $result['urlEdit']=$urlEdit;
           foreach($anteriores as $anterior){
             $em->remove($anterior);
           }
           $em->flush();
        }
        
        // create a JSON-response with a 200 status code
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    private function createFormEspecializado($entity)
    {
        switch($entity->getTipoConfiguracion())
        {
            case Configuraciones::$IMAGEN:
                return $this->createForm(new ConfiguracionesImagenType(), $entity);
            case Configuraciones::$LINK_VIDEO:
                return $this->createForm(new ConfiguracionesLinkVideoType(), $entity);
            case Configuraciones::$TEXTO_LARGO:
                return $this->createForm(new ConfiguracionesTextType(), $entity);
            case Configuraciones::$TEXTO_CORTO:
                return $this->createForm(new ConfiguracionesStringType(), $entity);    
            default:
                return $this->createForm(new ConfiguracionesType(), $entity);
        }
    }
}

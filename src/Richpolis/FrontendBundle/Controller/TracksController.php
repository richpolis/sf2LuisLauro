<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\FrontendBundle\Entity\Tracks;
use Richpolis\FrontendBundle\Form\TracksType;

/**
 * Tracks controller.
 *
 * @Route("/backend/tracks")
 */
class TracksController extends Controller
{
    private $discos = null;
    protected function getFilters()
    {
        $filters=$this->get('session')->get('filters', array());
        return $filters;
    }

    protected function getDiscoDefault(){
        $filters = $this->getFilters();
        if(isset($filters['tracks'])){
            return $filters['tracks'];
        }else{
            $this->getDiscos();
            return $this->discos[0];
        }
    }

    protected function getDiscos(){
        $em = $this->getDoctrine()->getManager();
        if($this->discos == null){
            $this->discos = $em->getRepository('FrontendBundle:Discos')
                                   ->getDiscosActivas();
        }
        return $this->discos;
    }

    protected function getDiscoActual($discoId){
        $discos= $this->getDiscos();
        $discoActual=null;
        foreach($discos as $disco){
            if($disco->getId()==$discoId){
                $discoActual=$disco;
                break;
            }
        }
        return $discoActual;
    }
    
    /**
     * Lists all Tracks entities.
     * @Route("/", name="tracks")
     * 
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $filters = $this->getFilters();

        if(!isset($filters['tracks']))
            return $this->redirect($this->generateUrl('tracks_seleccionar_disco'));

        $query = $em->getRepository("FrontendBundle:Tracks")
                    ->getQueryTracksPorDiscoActivas($filters['tracks']);

        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            10
        );

        return array(
            'discos'      =>$this->getDiscos(),
            'disco_actual'=>$this->getDiscoActual($filters['tracks']),
            'pagination'      =>$pagination,
        );
    }
    
    /**
     * Seleccionar un tipo de disco.
     *
     * @Route("/seleccionar/disco", name="tracks_seleccionar_disco")
     */
    public function selectAction()
    {
        $filters = $this->getFilters();
        
        if(isset($filters['tracks'])){
            return $this->redirect($this->generateUrl('tracks'));
        }else{
            return $this->render('FrontendBundle:Tracks:select.html.twig', array(
                'discos'  => $this->getDiscos(),
            ));
        }
    }
    
    /**
     * Mostrar por disco
     *
     * @Route("/list/{disco}/disco", name="tracks_por_disco")
     */
    public function porCategoriaAction($disco)
    {
        $filters = $this->getFilters();
        if($disco){
            $filters['tracks']=$disco;
            $this->get('session')->set('filters',$filters);
            return $this->redirect($this->generateUrl('tracks'));
        }else{
            if(isset($filters['tracks'])){
                return $this->redirect($this->generateUrl('tracks'));
            }else{
                return $this->render('FrontendBundle:Tracks:select.html.twig', array(
                    'discos'  => $this->getDiscos(),
                ));
            }
        }        
    }
    
    /**
     * Finds and displays a Tracks entity.
     *
     * @Route("/{id}/show", name="tracks_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Tracks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tracks entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    
    /**
     * Displays a form to create a new Tracks entity.
     *
     * @Route("/new", name="tracks_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tracks();
        
        $discoId=$this->getRequest()->query->get('disco',$this->getDiscoDefault());
        
        $disco=$this->getDoctrine()->getRepository('FrontendBundle:Discos')
                                   ->find($discoId);
        if(!is_null($disco)){
            $entity->setDisco($disco);
        }else{
            throw $this->createNotFoundException('Es necesario un disco para continuar.');
        }
                
        $max=$this->getDoctrine()->getRepository('FrontendBundle:Tracks')->getMaxPosicion($disco->getId());
        
        if(!is_null($max)){
            $entity->setPosicion($max+1);
        }else{
            $entity->setPosicion(1);
        }
        
        
        $form   = $this->createForm(new TracksType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Tracks entity.
     *
     * @Route("/create", name="tracks_create")
     * @Method("POST")
     * @Template("FrontendBundle:Tracks:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Tracks();
        $form = $this->createForm(new TracksType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tracks_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tracks entity.
     *
     * @Route("/{id}/edit", name="tracks_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Tracks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tracks entity.');
        }

        $editForm = $this->createForm(new TracksType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tracks entity.
     *
     * @Route("/{id}/update", name="tracks_update")
     * @Method("POST")
     * @Template("FrontendBundle:Tracks:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Tracks')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tracks entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TracksType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tracks_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tracks entity.
     *
     * @Route("/{id}/delete", name="tracks_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Tracks')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tracks entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tracks'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Subir registro de Tracks.
     *
     * @Route("/{id}/up", name="tracks_up")
     * @Method("GET")
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroUp = $em->getRepository('FrontendBundle:Tracks')->find($id);
        
        if ($registroUp) {
            $registroDown=$em->getRepository('FrontendBundle:Tracks')->getRegistroUpOrDown($registroUp,true);
            if ($registroDown) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('tracks',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
    
    /**
     * Subir registro de Tracks.
     *
     * @Route("/{id}/down", name="tracks_down")
     * @Method("GET")
     */
    public function downAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $registroDown = $em->getRepository('FrontendBundle:Tracks')->find($id);
        
        if ($registroDown) {
            $registroUp=$em->getRepository('FrontendBundle:Tracks')->getRegistroUpOrDown($registroDown,false);
            if ($registroUp) {
                $posicion=$registroUp->getPosicion();
                $registroUp->setPosicion($registroDown->getPosicion());
                $registroDown->setPosicion($posicion);
                $em->flush();
            }
        }
        
        return $this->redirect($this->generateUrl('tracks',array(
            'page'=>$this->getRequest()->query->get('page', 1)
        )));
    }
    
}

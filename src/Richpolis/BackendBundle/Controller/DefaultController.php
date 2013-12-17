<?php

namespace Richpolis\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="backend_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/navegar", name="backend_navegar")
     * @Template()
     */
    public function navegarAction()
    {
        return array();
    }
    
    /**
     * @Route("/seleccionar/galeria", name="backend_categorias")
     */
    public function categoriasAction()
    {
        return $this->forward('CategoriasGaleriaBundle:Categorias:select');
    }
    
    /**
     * @Route("/galeria/noticias", name="backend_galerias_noticias")
     */
    public function galeriaNoticiasAction()
    {
        return $this->forward('CategoriasGaleriaBundle:Categorias:galeriasNoticias');
    }
    
    /**
     * @Route("/publicacion/noticias", name="publicaciones_noticias")
     */
    public function publicacionesNoticiasAction()
    {
        return $this->forward('PublicacionesBundle:Publicacion:publicacionesNoticias');
    }
    
    /**
     * @Route("/publicacion/blog", name="publicaciones_blog")
     */
    public function publicacionesBlogAction()
    {
        return $this->forward('PublicacionesBundle:Publicacion:publicacionesBlog');
    }
    
    /**
     * @Route("/publicacion/biografia", name="publicaciones_biografia")
     */
    public function publicacionesBiografiaAction()
    {
        return $this->forward('PublicacionesBundle:Publicacion:publicacionesBiografia');
    }
    
    /**
     * @Route("/administrar/discos", name="backend_discos")
     */
    public function administrarDiscosAction()
    {
        return $this->forward('FrontendBundle:Discos:index');
    }
    
    /**
     * @Route("/administrar/tracks", name="backend_tracks")
     */
    public function administrarTracksAction()
    {
        return $this->forward('FrontendBundle:Tracks:select');
    }
    
    /**
     * @Route("/configuraciones", name="backend_configuraciones")
     */
    public function configuracionesAction()
    {
        return $this->forward('BackendBundle:Configuraciones:index');
    }
    
    /**
     * @Route("/login", name="backend_login")
     * @Template()
     */
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'BackendBundle:Default:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    /**
     * @Route("/login_check", name="backend_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="backend_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    
    
}

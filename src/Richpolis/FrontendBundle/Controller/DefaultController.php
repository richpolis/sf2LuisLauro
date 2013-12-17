<?php

namespace Richpolis\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\BackendBundle\Entity\Contacto;
use Richpolis\BackendBundle\Form\ContactoType;
use Richpolis\CategoriasGaleriaBundle\Entity\Categorias;

/**
 * Frontend controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {
    
    
    /**
     * Lists all Frontend entities.
     *
     * @Route("/")
     */
    public function entradaAction()
    {
        $locale = $this->getRequest()->getLocale();
        return $this->redirect($this->generateUrl('homepage',array('_locale'=>$locale)));
    }
    
    
    /**
     * Lists all Frontend entities.
     *
     * @Route("/{_locale}/", name="homepage",defaults={"_locale" = "en"}, requirements={"_locale" = "en|es"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('PublicacionesBundle:CategoriasPublicacion')
                        ->findOneBySlug('noticias');

        $query = $em->getRepository("PublicacionesBundle:Publicacion")
                    ->getQueryPublicacionPorCategoriaActivas($categoria->getId());
        
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            3,
            array('distinct' => true)
        );

        $data = $pagination->getPaginationData();

        $configuraciones = $em->getRepository('BackendBundle:Configuraciones')->findAll();

        return array(
            'pagination' => $pagination,
            'data'=>$data,
            'configuraciones' =>$configuraciones
        );
    }

    /**
     * Lists all Frontend entities.
     *
     * @Route("/{_locale}/bio", name="biografia",defaults={"_locale" = "en"}, requirements={"_locale" = "en|es"})
     * @Template()
     */
    public function biografiaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('PublicacionesBundle:CategoriasPublicacion')
                        ->findOneBySlug('biografia');

        $registros = $em->getRepository("PublicacionesBundle:Publicacion")
                    ->getPublicacionPorCategoriaActivas($categoria->getId(),false,'ASC');
        
        $configuraciones = $em->getRepository('BackendBundle:Configuraciones')->findAll();
        
        return array(
            'registros' => $registros,
            'configuraciones' =>$configuraciones
        );
    }

    /**
     * Lists all news.
     *
     * @Route("/{_locale}/blog", name="blog",defaults={"_locale" = "en"}, requirements={"_locale" = "en|es"})
     * @Method({"GET"})
     * @Template()
     */
    public function blogAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository('PublicacionesBundle:CategoriasPublicacion')
                        ->findOneBySlug('blog');

        $query = $em->getRepository("PublicacionesBundle:Publicacion")
                    ->getQueryPublicacionPorCategoriaActivas($categoria->getId());
        
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $this->getRequest()->query->get('page', 1),
            3,
            array('distinct' => true)
        );

        $data = $pagination->getPaginationData();

        $configuraciones = $em->getRepository('BackendBundle:Configuraciones')->findAll();

        return array(
            'pagination' => $pagination,
            'data'=>$data,
            'configuraciones' => $configuraciones
        );
        
    }

    
    /**
     * Lista los ultimos tweets.
     *
     * @Route("/last-tweets/{username}/", name="last_tweets")
     */
    public function lastTweetsAction($username, $limit = 10, $age = null)
    {
        /* @var $twitter FetcherInterface */
        $twitter = $this->get('knp_last_tweets.last_tweets_fetcher');

        try {
            $tweets = $twitter->fetch($username, $limit);
        } catch (TwitterException $e) {
            $tweets = array();
        }

        $response = $this->render('FrontendBundle:Default:lastTweets.html.twig', array(
            'username' => $username,
            'tweets'   => $tweets,
        ));

        if ($age) {
            $response->setSharedMaxAge($age);
        }

        return $response;
    }
    
    /**
     * Lista de los ultimos medias del usuario.
     *
     * @Route("/instagram/media/{username}/", name="instagram_media")
     */
    public function instagramMediaAction($username)
    {
        $metadata = \Richpolis\BackendBundle\Utils\Richsys::getInstagramMedia($username);
        $response = $this->render('FrontendBundle:Default:instagramMedia.html.twig', array(
            'username' => $username,
            'metadata'   => $metadata,
        ));

        return $response;
    }
    
    /**
     * Lista todos los artistas.
     *
     * @Route("/{_locale}/music", name="music",defaults={"_locale" = "en"}, requirements={"_locale" = "en|es"})
     * @Template()
     */
    public function musicAction()
    {
        $em = $this->getDoctrine()->getManager();


        $discos = $em->getRepository("FrontendBundle:Discos")
                    ->getDiscosAndTracks();
        
        $configuraciones = $em->getRepository('BackendBundle:Configuraciones')->findAll();
        
        return array(
            'discos' => $discos,
            'configuraciones' =>$configuraciones
        );
    }
    
    
    

    /**
     * @Route("/{_locale}/contact", name="frontend_contacto",defaults={"_locale" = "en"}, requirements={"_locale" = "en|es"})
     * @Method({"GET", "POST"})
     */
    public function contactoAction() {
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $datos=$form->getData();
                
                
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contacto desde pagina')
                        ->setFrom($datos->getEmail())
                        ->setTo($this->container->getParameter('richpolis.emails.to_email'))
                        ->setBody($this->renderView('BackendBundle:Default:contactoEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('noticia', 'Gracias por enviar tu correo, nos comunicaremos a la brevedad posible!');

                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $ok=true;
                $error=false;
                $mensaje="Gracias, mensaje enviado.";
                $contacto = new Contacto();
                $form = $this->createForm(new ContactoType(), $contacto);
            }else{
                $ok=false;
                $error=true;
                $mensaje="El mensaje no se ha podido enviar";
            }
        }else{
            $ok=false;
            $error=false;
            $mensaje="Violacion de acceso";
        }
        
        return $this->render("FrontendBundle:Default:contacto.html.twig",array(
              'form' => $form->createView(),
              'ok'=>$ok,
              'error'=>$error,
              'mensaje'=>$mensaje,
        ));
    }
    
   
    
}

?>

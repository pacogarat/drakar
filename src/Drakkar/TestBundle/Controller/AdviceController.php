<?php

namespace Drakkar\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/advice")
 * 
 */
class AdviceController extends Controller
{
    /**
     * @Route("/create", name="drakkar_advice_create")
     * @Method({"PUT"})
     */
    public function createAction(Request $request)
    {
        $item = $this->getDoctrine()->getRepository('DrakkarTestBundle:Item')->findOneById($request->get('item'));
        if (!$item) {
            $response = new JsonResponse();
            $response->setContent(json_encode(array(
                'error' => true,
                'message' => 'No se ha podido realizar la recomendación, no se ha encontrado el artículo'
            )));
            $response->setStatusCode(500);
            return $response;
        }
        $advice = new \Drakkar\TestBundle\Entity\Advice();
        $advice->setUser($this->getUser());
        $advice->setItem($item);
        $this->getDoctrine()->getManager()->persist($advice);
        $this->getDoctrine()->getManager()->flush();
        $response = new JsonResponse();
        $response->setContent(json_encode(array(
            'error' => false,
            'message' => 'Recomendación realizada con éxito'
        )));
        
        $response->setStatusCode(200);
        return $response;
    }
    
    /**
     * @Route("/", name="drakkar_advice_index")
     * @Route("/{page}", name="drakkar_advice_index_paginated")
     * @Template()
     */
    public function indexAction($page=null)
    {
        $page = (empty($page))?1:$page;
        $advice_dispatcher = $this->get('drakkar.advice.dispatcher');
        $advices = $advice_dispatcher->getAdvices($this->getUser(), array('page'=>$page));
        return array(
            'advices' => $advices,
            'page' => $page
                );
    }
}
<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction()
    {
        return $this->render('CallMeWebBundle:Phone:call.html.twig');
    }

    /**
     * @param Request $request
     */
    public function processCallAction(Request $request)
    {
        $number = $request->request->get('number');
        $this->get('twilio')->account->calls->create(
            '5704563355',
             $number,
            $this->generateUrl('dial_callback', [], true)
        );
        return $this->redirect($this->generateUrl('make_call'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processCallBackAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render(
            'CallMeWebBundle:Phone:callback.xml.twig',
            ['number' => $request->request->get('number')],
            $response
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function processMessageAction (Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('CallMeWebBundle:Phone:message.xml.twig',
            ['number' => $request->request->get('number')],
            $response
        );
    }
}
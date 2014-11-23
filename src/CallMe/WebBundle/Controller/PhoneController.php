<?php

namespace CallMe\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processCallAction(Request $request)
    {
        $number = $request->request->get('number');
        $type = $request->request->get('type');
        $message = $request->request->get('message');
        try {

            if ($type == 'dial' ){
                $this->get('twilio')->account->calls->create(
                    $this->container->getParameter('twilio_number'),
                    $number,
                    $this->generateUrl('dial_callback', [], true)

                );
                $message = 'Your phone call has been sent.';
            } else if ($type == 'message') {
                $this->get('twilio')->account->messages->sendMessage(
                    $this->container->getParameter('twilio_number'),
                    $number,
                    $message
                );
                $message = 'Your message has been sent';

            }
        } catch (\Services_Twilio_RestException $e) {
            $this->get('logger')->error($e->getMessage());
                $message = 'An error occurred during this operation';
        }
        return new JsonResponse(['message' => $message]);
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
    public function processMessageAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render(
            'CallMeWebBundle:Phone:message.xml.twig',
            ['number' => $request->request->get('number')],
            $response
        );
    }
}
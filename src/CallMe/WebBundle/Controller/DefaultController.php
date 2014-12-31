<?php

namespace CallMe\WebBundle\Controller;

use CallMe\WebBundle\Entity\Audio\AudioManager;
use CallMe\WebBundle\Entity\User;
use CallMe\WebBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('dashboard_index'));
        }
        return $this->render('CallMeWebBundle:Default:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {
        return $this->render('CallMeWebBundle:Default:register.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processRegisterAction(Request $request)
    {
        $form = $this->createForm(new RegisterType());
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $newUser = $this->get('user_manager')->createUser($form->getData());

            $token = new UsernamePasswordToken($newUser, null, 'main', $newUser->getRoles());
            $this->get('security.context')->setToken($token);
            return $this->redirect($this->generateUrl('call_me_web_homepage'));
        }

        return $this->redirect($this->generateUrl('register_page'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('CallMeWebBundle:Dashboard:dash.html.twig', [
            'audio' => $this->get('audio_manager')->fetchAudioByUser($this->getUser()),
            'phoneCalls' => $this->get('phone_call_manager')->fetchPhoneCallsByUser($this->getUser())
        ]);
    }
}

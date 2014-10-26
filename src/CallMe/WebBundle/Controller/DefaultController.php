<?php

namespace CallMe\WebBundle\Controller;

use CallMe\WebBundle\Entity\User;
use CallMe\WebBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
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
            $this->get('user_manager')->createUser($form->getData());
            return $this->redirect($this->generateUrl('call_me_web_homepage'));
        }

        return $this->redirect($this->generateUrl('register_page'));
    }
}

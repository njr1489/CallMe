<?php

namespace CallMe\WebBundle\Controller;

use CallMe\WebBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CallMeWebBundle:Default:index.html.twig');
    }

    public function registerAction()
    {
        return $this->render('CallMeWebBundle:Default:register.html.twig');
    }

    public function processRegisterAction(Request $request)
    {
        $data = $request->request->all();
    }
}
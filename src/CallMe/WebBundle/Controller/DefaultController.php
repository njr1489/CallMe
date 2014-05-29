<?php

namespace CallMe\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
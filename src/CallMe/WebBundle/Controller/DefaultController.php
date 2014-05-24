<?php

namespace CallMe\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CallMeWebBundle:Default:index.html.twig', array('name' => $name));
    }
}

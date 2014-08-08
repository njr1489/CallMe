<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adamc
 * Date: 8/7/14
 * Time: 9:02 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function settingsAction()
    {
        $user = $this->getUser();
        return $this->render('CallMeWebBundle:User:settings.html.twig', ['first_name' => $user->getFirstName()]);
    }

    public function processSettingsAction(Request $request)
    {

    }
}
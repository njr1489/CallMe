<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adamc
 * Date: 6/7/14
 * Time: 12:42 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Controller;

use CallMe\WebBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;


class SecurityController extends Controller {

    public function loginAction(Request $request)
    {

        $session = $request->getsession();

        //get login error, if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_Error);
        }
        elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_Error))
        {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = 'You are not authorized to access this page';
        }

        $lastUsername = (null == $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render('',array('last_username'=>$lastUsername, 'error'=>$error,));
    }

}
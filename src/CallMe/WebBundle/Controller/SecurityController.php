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
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render(
            'CallMeWebBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    public function forgotPasswordAction()
    {
        return $this->render('CallMeWebBundle:Security:forgot-password.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processForgotPasswordAction(Request $request)
    {
        $email = $request->request->get('email');
        try {
            $this->get('user_manager')->loadUserByUsername($email);
            // @TODO: Reset password logic
            $this->get('session')->getFlashBag()->add(
                'email',
                'Email has been sent to ' . $email
            );

            return $this->redirect($this->generateUrl('login'));
        } catch (UsernameNotFoundException $e) {
            $this->get('session')->getFlashBag()->add(
                'email',
                $email . ' could not be found'
            );

            return $this->redirect($this->generateUrl('forgot_password'));
        }
    }
}

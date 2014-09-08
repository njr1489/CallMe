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
            $token = $this->get('user_manager')->generateResetPasswordToken($email);

            $message = \Swift_Message::newInstance()
                ->setSubject('Password Reset Request')
                ->setFrom($this->container->getParameter('staff_email'))
                ->setTo($email)
                ->setContentType('text/html')
                ->setBody($this->renderView(
                    'CallMeWebBundle:Email:reset-password.html.twig',
                    ['email' => md5($email), 'token' => $token]
                ));
            $this->get('mailer')->send($message);

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

    /**
     * @param $token
     * @param $email
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resetPasswordAction($token, $email)
    {
        try {
            $user = $this->get('user_manager')->loadUserByResetPasswordToken($token);
            if ($email != md5($user->getEmail())) {
                return $this->redirect($this->generateUrl('login'));
            }

            return $this->render('CallMeWebBundle:Security:reset-password.html.twig', ['token' => $token]);
        } catch (UsernameNotFoundException $e) {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    /**
     * @param Request $request
     */
    public function processResetPassword(Request $request)
    {

    }
}

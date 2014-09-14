<?php

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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
     * @param $hashedEmail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resetPasswordAction($token, $hashedEmail)
    {
        try {
            $user = $this->get('user_manager')->loadUserByResetPasswordToken($token);
            $expiration = $user->getPasswordResetExpiration();
            if ($hashedEmail != md5($user->getEmail()) || ($expiration && new \DateTime() > $expiration)) {
                return $this->redirect($this->generateUrl('login'));
            }

            return $this->render('CallMeWebBundle:Security:reset-password.html.twig', ['token' => $token, 'hashedEmail' => $hashedEmail]);
        } catch (UsernameNotFoundException $e) {
            return $this->redirect($this->generateUrl('login'));
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processResetPasswordAction(Request $request)
    {
        if ($request->get('password') != $request->get('confirm_password')) {
            $this->get('session')->getFlashBag()->add('password', 'Please confirm password and confirm password are the same.');
            return $this->redirect($this->generateUrl('reset_password', ['token' => $request->get('token'), 'hashedEmail' => $request->get('hashedEmail')]));
        }

        try {
            $user = $this->get('user_manager')->loadUserByResetPasswordToken($request->get('token'));
            $expiration = $user->getPasswordResetExpiration();
            if ($request->get('hashedEmail') != md5($user->getEmail()) || ($expiration && new \DateTime() > $expiration)) {
                return $this->redirect($this->generateUrl('login'));
            }
            $this->get('user_manager')->resetUserPassword($user, $request->get('password'));
            $this->get('session')->getFlashBag()->add('password', 'Password was successfully reset.');
        } catch (UsernameNotFoundException $e) {
        }

        return $this->redirect($this->generateUrl('login'));
    }
}

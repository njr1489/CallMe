<?php

namespace CallMe\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function settingsAction()
    {
        $user = $this->getUser();
        return $this->render('CallMeWebBundle:User:settings.html.twig', [
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function processSettingsAction(Request $request)
    {
        $data = $request->request->all();
        $this->get('user_manager')->updateUser($data);
        return $this->redirect($this->generateUrl('user_settings'));
    }
}
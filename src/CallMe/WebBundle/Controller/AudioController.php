<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 9/23/14
 * Time: 9:11 PM
 * To change this template use File | Settings | File Templates.
 */
namespace CallMe\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AudioController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('CallMeWebBundle:Audio:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function uploadAudioAction(Request $request)
    {
        $file = $request->files->get('file');

        try {
            $this->get('audio_uploader')->uploadAudio($request->request->get('name'), $file->getPath().'/'.$file->getFilename(), $this->getUser());
            $this->get('session')->getFlashBag()->add('notice', 'Your file was successfully uploaded.');
        } catch (\InvalidArgumentException $e) {
            $this->get('session')->getFlashBag()->add('notice', 'An error happened while you were trying to upload, please try again.');
        }
        return $this->redirect($this->generateUrl('audio_index'));
    }
}

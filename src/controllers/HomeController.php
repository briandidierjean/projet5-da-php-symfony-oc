<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\Message;
use \App\FormBuilder\MessageFormBuilder;
use \Core\Mail;

class HomeController extends Controller
{
    /**
     * This method show the home page with the contact form.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be passed.
     * @param HTTPResponse $httpResponse HTTP response to be passed.
     * 
     * @return void
     */
    public function index(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        if ($httpRequest->getMethod() == 'POST') {
            $message = new Message(
                [
                    'name' => $httpRequest->getPost('name'),
                    'email' => $httpRequest->getPost('email'),
                    'message' => $httpRequest->getPost('message')
                ]
            );
        } else {
            $message = new Message;
        }

        $formBuilder = new MessageFormBuilder($message);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $mail = new Mail($message->getEmail(), $message->getMessage());
            $mail->send();

            $httpResponse->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'home/index.html.twig',
            ['form' => $form->createView()]
        );

        $httpResponse->send($this->page);
    }
}

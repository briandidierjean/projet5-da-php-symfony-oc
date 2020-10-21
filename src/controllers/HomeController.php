<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Mail;
use \App\Model\Entity\Message;
use \App\FormBuilder\MessageFormBuilder;
use \App\FormHandler\SendingMessageFormHandler;

class HomeController extends Controller
{
    /**
     * Show the home page with the contact form
     *
     * @return void
     */
    public function index()
    {
        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'name' => $this->httpRequest->getPost('name'),
                'email' => $this->httpRequest->getPost('email'),
                'message' => $this->httpRequest->getPost('message')
            ];
        }

        $formBuilder = new MessageFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new SendingMessageFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
        );

        if ($formHandler->process()) {
            $this->httpResponse->redirect();
        }
        
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'home/index.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }
}

<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Mail;
use \App\FormBuilder\ContactMessageFormBuilder;
use \App\FormHandler\ContactMessageFormHandler;

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

        $formBuilder = new ContactMessageFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new ContactMessageFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
        );

        if ($formHandler->process()) {
            $this->httpResponse->redirect('/');
        }

        $this->page = $this->twig->render(
            'home/index.html.twig',
            [
                'form' => $form->createView()
            ]
        );

        $this->httpResponse->send($this->page);
    }
}

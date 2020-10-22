<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Mail;

class SendingMessageFormHandler
{
    protected $httpRequest;
    protected $httpResponse;
    protected $form;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Form $form
    ) {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->form = $form;
    }

    /**
     * Process the form to send a message
     *
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $email = $this->form->getData('email');
            $name = $this->form->getData('name');
            $message = $this->form->getData('message');

            $mail = new Mail($email, $name, $message);

            $mail->send();

            return true;
        }

        return false;
    }
}

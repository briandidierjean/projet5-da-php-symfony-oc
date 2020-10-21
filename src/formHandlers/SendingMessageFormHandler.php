<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Mail;

class SendingMessageFormHandler extends FormHandler
{
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

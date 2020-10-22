<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Authentication;
use \Core\Form;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class SigningUpFormHandler
{
    protected $httpRequest;
    protected $httpResponse;
    protected $authentication;
    protected $form;
    protected $userManager;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Authentication $authentication,
        Form $form,
        UserManager $userManager
    ) {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->authentication = $authentication;
        $this->form = $form;
        $this->userManager = $userManager;
    }

    /**
     * Process the form to sign up a user
     *
     * @return bool
     */
    public function process()
    {
        $error = false;

        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $email = $this->form->getData('email');

            if ($this->userManager->exists($email)) {
                $this->form->addErrorMsg(
                    'L\'adresse e-mail est déjà utilisée',
                    ['email']
                );

                $error = true;
            }
            
            $password = $this->form->getData('password');
            $confirmedPassword = $this->form->getData('confirmedPassword');
            if ($password != $confirmedPassword) {
                $this->form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    ['password', 'confirmedPassword']
                );

                $error = true;
            }

            if ($error) {
                return false;
            }

            $user  = new User(
                [
                    'email' => $this->form->getData('email'),
                    'password' => $this->form->getData('password'),
                    'firstName' => $this->form->getData('firstName'),
                    'lastName' => $this->form->getData('lastName')
                ]
            );
            $this->userManager->save($user);

            $user = $this->userManager->get($user->getEmail());

            $this->authentication->setConnexion($user->getId(), $user->getEmail());

            return true;
        }

        return false;
    }
}

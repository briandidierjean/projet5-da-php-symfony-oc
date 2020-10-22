<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Authentication;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class SigningUpFormHandler extends FormHandler
{
    protected $userManager;
    protected $authentication;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Form $form,
        UserManager $userManager,
        Authentication $authentication
    ) {
        parent::__construct($httpRequest, $httpResponse, $form);

        $this->userManager = $userManager;
        $this->authentication = $authentication;
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

<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Authentication;
use \Core\Form;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class SigningInFormHandler
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
     * Process the form to sign in a user
     *
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $email = $this->form->getData('email');

            if ($this->userManager->exists($email)) {
                $user = $this->userManager->get($email);

                $password = $this->form->getData('password');

                if (password_verify($password, $user->getPassword())) {
                    $staySignedIn = $this->form->getData('staySignedIn');
                    
                    if (!empty($staySignedIn)) {
                        $this->authentication->saveConnexion(
                            $user->getId(),
                            $user->getEmail()
                        );
                    }

                    $this->authentication->setConnexion(
                        $user->getId(),
                        $user->getEmail()
                    );

                    return true;
                }
            }

            $this->form->addErrorMsg(
                'E-mail ou mot de passe incorrect',
                ['email', 'password']
            );

            return false;
        }
    }
}

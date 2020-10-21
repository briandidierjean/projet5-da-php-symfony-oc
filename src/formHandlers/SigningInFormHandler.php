<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Authentication;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class SigningInFormHandler extends FormHandler
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

                    if ($staySignedIn) {
                        $this->authentication->saveConnexion($email);
                    }

                    $this->authentication->setConnexion($email);

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

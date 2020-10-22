<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Authentication;
use \Core\Form;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class ChangingPasswordFormHandler
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
     * Process the form to change user password
     *
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $user = $this->manager->get($this->authentication->getEmail());

            $formerPassword = $this->form->getData('formerPassword');
            $newPassword = $this->form->getData('newPassword');
            $newConfirmedPassword = $this->form->getData('newConfirmedPassword');

            if (password_verify($formerPassword, $user->getPassword())) {
                if ($newPassword == $newConfirmedPassword) {
                    $user->setPassword($newPassword);

                    $userManager->save($user);

                    return true;
                }

                $form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    ['newPassword', 'newConfirmedPassword']
                );

                return false;
            }

            $form->addErrorMsg(
                'L\'ancien mot de passe est inccorect',
                ['formerPassword']
            );

            return false;
        }

        return false;
    }
}

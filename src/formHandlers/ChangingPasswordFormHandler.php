<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Authentication;
use \App\Model\Entity\User;
use \App\Model\Manager\UserManager;

class ChangingPasswordFormHandler extends FormHandler
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

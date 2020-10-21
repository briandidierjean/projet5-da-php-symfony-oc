<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\MatchedValidator;
use \App\Model\Entity\User;
use \App\FormBuilder\ChangingPasswordFormBuilder;
use \App\FormBuilder\SigningInFormBuilder;
use \App\FormBuilder\SigningUpFormBuilder;
use \App\FormHandler\ChangingPasswordFormHandler;
use \App\FormHandler\SigningInFormHandler;
use \App\FormHandler\SigningUpFormHandler;

class UserController extends Controller
{
    /**
     * Sign in a user
     *
     * @return void
     */
    public function signIn()
    {
        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'email' => $this->httpRequest->getPost('email'),
                'password' => $this->httpRequest->getPost('password')
            ];
        }

        $formBuilder = new SigningInFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $signingInFormHandler = new SigningInFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
            $this->managers->getManagerOf('User'),
            $this->authentication
        );

        if ($signingInFormHandler->process()) {
            $this->httpResponse->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signIn.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }


    /**
     * Sign out a user
     *
     * @return void
     */
    public function signOut()
    {
        $this->authentication->unsetConnexion();

        $this->httpResponse->redirect('/');
    }

    /**
     * Sign up a user
     * 
     * @return void
     */
    public function signUp()
    {
        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'email' => $this->httpRequest->getPost('email'),
                'password' => $this->httpRequest->getPost('password'),
                'confirmedPassword' => $this->httpRequest->getPost('confirmedPassword'),
                'firstName' => $this->httpRequest->getPost('firstName'),
                'lastName' => $this->httpRequest->getPost('lastName')
            ];
        }

        $formBuilder = new SigningUpFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $signingUpFormHandler = new SigningUpFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
            $this->managers->getManagerOf('User'),
            $this->authentication
        );

        if ($signingUpFormHandler->process()) {
            $this->httpResponse->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signUp.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Change the user password
     * 
     * @return void
     */
    public function changePassword()
    {
        if ($this->authentication->isSignedIn()) {
            $this->httpResponse->redirect('/sign-in');
        }

        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'formerPassword' => $this->httpRequest->getPost(
                    'formerPassword'
                ),
                'newPassword' => $this->httpRequest->getPost(
                    'newPassword'
                ),
                'newConfirmedPassword' => $this->httpRequest->getPost(
                    'newConfirmedPassword'
                )
            ];
        }
        
        $formBuilder = new ChangingPasswordFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $changePasswordFormHandler = new ChangePasswordFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
            $this->managers->getManagerOf('User'),
            $this->authentication
        );

        if ($changePasswordFormHandler->process()) {
            $this->httpResponse->redirect('/');
        }

        if ($this->httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            $user = $userManager->get($this->httpRequest->getSession('authEmail'));

            if (password_verify($formData['formerPassword'], $user->getPassword())) {
                if ($formData['newPassword'] == $formData['newConfirmedPassword']) {
                    $user->setPassword($formData['newPassword']);

                    $userManager->save($user);

                    $this->httpResponse->redirect('/');
                }
                $form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    'newPassword'
                );
                $form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    'newConfirmedPassword'
                );
            } else {
                $form->addErrorMsg(
                    'L\'ancien mot de passe est inccorect',
                    'formerPassword'
                );
            }
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/changePassword.html.twig',
            [
                'form' => $form->createView(),
                'isAuth' => $this->httpRequest->getSession('isAuth')
            ]
        );

        $this->httpResponse->send($this->page);
    }
}

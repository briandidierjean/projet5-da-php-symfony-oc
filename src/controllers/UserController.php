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

class UserController extends Controller
{
    /**
     * This method signs in a user.
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function signIn(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        $data = [];

        if ($httpRequest->getMethod() == 'POST') {
            $data = [
                'email' => $httpRequest->getPost('email'),
                'password' => $httpRequest->getPost('password')
            ];
        }

        $formBuilder = new SigningInFormBuilder($data);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            $user = $userManager->get($data['email']);

            if ($user->getEmail() != $data['email']
                || !password_verify($data['password'], $user->getPassword())
            ) {
                throw new \Exception('Adresse email out mot de passe incorrect');
            }
            $httpResponse->setSession('user', $user);
            $httpResponse->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signIn.html.twig',
            ['form' => $form->createView()]
        );

        $httpResponse->send($this->page);
    }

    /**
     * This method signs up a user.
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function signUp(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        $data = [];

        if ($httpRequest->getMethod() == 'POST') {
            $data = [
                'email' => $httpRequest->getPost('email'),
                'password' => $httpRequest->getPost('password'),
                'confirmedPassword' => $httpRequest->getPost('confirmedPassword'),
                'firstName' => $httpRequest->getPost('firstName'),
                'lastName' => $httpRequest->getPost('lastName')
            ];
        }

        $formBuilder = new SigningUpFormBuilder($data);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            if ($userManager->exists($data['email'])) {
                throw new \Exception('Cet adresse email est déjà utilisée');
            }
            if ($data['password'] != $data['confirmedPassword']) {
                throw new \Exception('Les mots de passe ne correspondent pas');
            }
            $user  = new User(
                [
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName']
                ]
            );
            $userManager->save($user);

            $httpResponse->setSession('user', $user);

            $httpResponse->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signUp.html.twig',
            ['form' => $form->createView()]
        );

        $httpResponse->send($this->page);
    }

    /**
     * This method changes the user password.
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function changePassword(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse
    ) {
        if (!$httpRequest->sessionExist($user)) {
            throw new \Exception('Not signed in');
        }
        $user = $httpRequest->getSession($user);

        $data = [];

        if ($httpRequest->getMethod() == 'POST') {
            $data = [
                'formerPassword' => $httpRequest->getPost('formerPassword'),
                'newPassword' => $httpRequest->getPost('newPassword'),
                'confirmedNewPassword' => $httpRequest->getPost('confirmedNewPassword')
            ];
        }
        
        $formBuilder = new ChangingPasswordFormBuilder($data);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            
        }

        $formHandler = new FormHandler($form, $user, $httpRequest);

        if ($formHandler->saveProcess($this->managers->getManagerOf('User'))) {
            $response = $this->managers->getManagerOf('User')->get($user->getEmail());

            $httpResponse->setSession('user', $response);
            $httpResponse->redirect('/');
        }
    }

    /**
     * This method return the administration panel.
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function admin(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        if ($httpRequest->getSession($user) === null) {
            $httpResponse->redirect('/sign-in');
        }

        $user = $httpRequest->getSession($user);

        if ($httpRequest->getMethod() == 'POST') {
            $user = new User(
                [
                    'email' => $httpRequest->getPost('email'),
                    'password' => $httpRequest->getPost('password'),
                    'confirmedPassword' => $httpRequest->getPost('confirmedPassword'),
                    'firstName' => $httpRequest->getPost('firstName'),
                    'lastName' => $httpRequest->getPost('lastName')
                ]
            );
        } else {
            $user = new User;
        }

        if (!$user->getRole() == 'administrator') {
            throw new \Exception('Seuls les administrateurs peuvent accéder à cette page');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/admin.html.twig',
            []
        );

        $httpResponse->send($this->page);
    }
}

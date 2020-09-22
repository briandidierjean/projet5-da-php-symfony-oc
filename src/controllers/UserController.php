<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;

class UserController extends Controller
{
    /**
     * This method signs in a user.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     * 
     * @return void
     */
    public function signIn(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        if ($httpRequest->getMethod() == 'POST') {
            $user = new User(
                [
                    'email' => $httpRequest->getPost('email'),
                    'password' => $httpRequest->getPost('password')
                ]
            );
        } else {
            $user = new User;
        }

        $formBuilder = new SigningInFormBuilder($user);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new FormHandler($form, $user, $httpRequest);

        $response = $formHandler->getProcess($this->managers->getManagerOf('User'));

        if ($response) {
            if (!password_verify($user->getPassword(), $response->getPassword())) {
                throw new \Exception('Mot de passe incorrect');
            }

            $httpResponse->setSession('user', $response);
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
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     * 
     * @return void
     */
    public function signUp(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        if ($httpRequest->getMethod() == 'POST') {
            $user = new User(
                [
                    'email' => $httpRequest->getPost('email'),
                    'password' => $httpRequest->getPost('password'),
                    'firstName' => $httpRequest->getPost('firstName'),
                    'lastName' => $httpRequest->getPost('lastName')
                ]
            );
        } else {
            $user = new User;
        }

        $formBuilder = new SigninUpFormBuilder($user);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new FormHandler($form, $user, $httpRequest);

        if ($formHandler->saveProcess($this->managers->getManagerOf('User'))) {
            $response = $this->managers->getManagerOf('User')->get($user->getEmail());

            $httpResponse->setSession('user', $response);
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
     * This method change the user password.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     * 
     * @return void
     */
    public function changePassword(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        $user = $httpRequest->getSession($user);
        
        $formBuilder = new ChangingPasswordFormBuilder($user);
        $formBuilder->build();

        $form = $formBuilder->getForm();

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
     * @param HTTPRequest $httpRequest HTTP request to be sent.
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
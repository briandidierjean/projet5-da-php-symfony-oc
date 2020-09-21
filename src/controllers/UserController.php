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
     * 
     * @return void
     */
    public function signIn(HTTPRequest $httpRequest)
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

        $userDatabase = $formHandler->getProcess($this->managers->getManagerOf('User'));

        if ($userDatabase) {
            if (!password_verify($user->getPassword(), $userDatabase->getPassword())) {
                throw new \Exception('Mot de passe incorrect');
            }

            $user->authenticate();
            
            $this->app->getHttpResponse()->redirect('/');
        }
            

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signIn.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * This method signs up a user.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * 
     * @return void
     */
    public function signUp(HTTPRequest $httpRequest)
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

        if ($formHandler->saveProcess()) {
            $this->app->getHttpResponse()->redirect('/');
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signUp.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * This method change the user password.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * 
     * @return void
     */
    public function changePassword(HTTPRequest $httpRequest)
    {

    }

    /**
     * This method return the administration panel.
     * 
     * @param HTTPRequest $httpRequest HTTP request to be sent.
     * 
     * @return void
     */
    public function adminPanel(HTTPRequest $httpRequest)
    {

    }
}
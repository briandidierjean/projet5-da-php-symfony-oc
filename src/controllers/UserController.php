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
     * Sign in a user
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function signIn(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        $formData = [];

        if ($httpRequest->getMethod() == 'POST') {
            $formData = [
                'email' => $httpRequest->getPost('email'),
                'password' => $httpRequest->getPost('password')
            ];
        }

        $formBuilder = new SigningInFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            if ($userManager->exists($formData['email'])) {
                $user = $userManager->get($formData['email']);

                if (password_verify($formData['password'], $user->getPassword())) {
                    if ($formData['staySignedIn']) {
                        $httpResponse->setCookie('isAuth', true);
                        $httpResponse->setCookie('authRole', $user->getRole());
                        $httpResponse->setCookie('authEmail', $user->getEmail());
                    }
                    $httpResponse->setSession('isAuth', true);
                    $httpResponse->setSession('authRole', $user->getRole());
                    $httpResponse->setSession('authEmail', $user->getEmail());

                    $httpResponse->redirect('/');
                }
            }
            $form->addErrorMsg(
                'L\'adresse e-mail ou le mot de passe est incorrect',
                'email'
            );
            $form->addErrorMsg(
                'L\'adresse e-mail ou le mot de passe est incorrect',
                'password'
            );
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signIn.html.twig',
            [
                'form' => $form->createView(),
                'isAuth' => $httpRequest->getSession('isAuth')
            ]
        );

        $httpResponse->send($this->page);
    }


    /**
     * Sign out a user
     *
     * @param HTTPRequest  $httpRequest  HTTP Request
     * @param HTTPResponse $httpResponse HTTP Response
     *
     * @return void
     */
    public function signOut(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        session_destroy();

        $httpResponse->setCookie('isAuth', false);
        $httpResponse->setCookie('authRole', '');
        $httpResponse->setCookie('authEmail', '');

        $httpResponse->redirect('/');
    }

    /**
     * Sign up a user
     *
     * @param HTTPRequest  $httpRequest  HTTP request to be sent.
     * @param HTTPResponse $httpResponse HTTP response to be sent.
     *
     * @return void
     */
    public function signUp(HTTPRequest $httpRequest, HTTPResponse $httpResponse)
    {
        $formData = [];

        if ($httpRequest->getMethod() == 'POST') {
            $formData = [
                'email' => $httpRequest->getPost('email'),
                'password' => $httpRequest->getPost('password'),
                'confirmedPassword' => $httpRequest->getPost('confirmedPassword'),
                'firstName' => $httpRequest->getPost('firstName'),
                'lastName' => $httpRequest->getPost('lastName')
            ];
        }

        $formBuilder = new SigningUpFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            if (!$userManager->exists($formData['email'])) {
                if ($formData['password'] == $formData['confirmedPassword']) {
                    $user  = new User(
                        [
                                'email' => $formData['email'],
                                'password' => $formData['password'],
                                'firstName' => $formData['firstName'],
                                'lastName' => $formData['lastName']
                            ]
                    );
                    $userManager->save($user);
        
                    $httpResponse->setSession('isAuth', true);
                    $httpResponse->setSession('authRole', $user->getRole());
                    $httpResponse->setSession('authEmail', $user->getEmail());
        
                    $httpResponse->redirect('/');
                }
                $form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    'password'
                );
                $form->addErrorMsg(
                    'Les mots de passe ne correspondent pas',
                    'confirmedPassword'
                );
            } else {
                $form->addErrorMsg('L\'adresse e-mail est déjà utilisée', 'email');
            }
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'user/signUp.html.twig',
            [
                'form' => $form->createView(),
                'isAuth' => $httpRequest->getSession('isAuth')
            ]
        );

        $httpResponse->send($this->page);
    }

    /**
     * Change the user password
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
        if (!$httpRequest->getSession('isAuth')) {
            $httpResponse->redirect('/sign-in');
        }

        $formData = [];

        if ($httpRequest->getMethod() == 'POST') {
            $formData = [
                'formerPassword' => $httpRequest->getPost(
                    'formerPassword'
                ),
                'newPassword' => $httpRequest->getPost(
                    'newPassword'
                ),
                'newConfirmedPassword' => $httpRequest->getPost(
                    'newConfirmedPassword'
                )
            ];
        }
        
        $formBuilder = new ChangingPasswordFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        if ($httpRequest->getMethod() == 'POST' && $form->isValid()) {
            $userManager = $this->managers->getManagerOf('User');

            $user = $userManager->get($httpRequest->getSession('authEmail'));

            if (password_verify($formData['formerPassword'], $user->getPassword())) {
                if ($formData['newPassword'] == $formData['newConfirmedPassword']) {
                    $user->setPassword($formData['newPassword']);

                    $userManager->save($user);

                    $httpResponse->redirect('/');
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
                'isAuth' => $httpRequest->getSession('isAuth')
            ]
        );

        $httpResponse->send($this->page);
    }
}

<?php
namespace Core;

session_start();

class Authentication extends ApplicationComponent
{
    protected $httpRequest;
    protected $httpResponse;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->httpRequest = $app->getHttpRequest();
        $this->httpResponse = $app->getHttpResponse();
    }

    /**
     * Check if a user is signed in
     *
     * @return bool
     */
    public function isSignedIn()
    {
        if ($this->httpRequest->getSession('auth')
            && $this->httpRequest->getSession('email') !== null
        ) {
            return true;
        }
        if ($this->httpRequest->getCookie('auth')
            && $this->httpRequest->getCookie('email')
        ) {
            $this->httpResponse->setSession('auth', true);
            $this->httpResponse->setSession(
                'email',
                $this->httpRequest->getCookie('email')
            );

            return true;
        }

        return false;
    }

    /**
     * Get the user email session
     * 
     * @return mixed
     */
    public function getEmail()
    {
        if ($this->httpRequest->getSession('auth')
            && $this->httpRequest->getSession('email') !== null
        ) {
            return $this->httpRequest->getSession('email');
        }
    }

    /**
     * Set a connexion session
     *
     * @param string $email Email address to set in the session
     *
     * @return void
     */
    public function setConnexion($email)
    {
        $this->httpResponse->setSession('auth', true);
        $this->httpResponse->setSession('email', $email);
    }

    /**
     * Set a connexion cookie
     * 
     * @param string $email Email address to save in the cookie
     * 
     * @return void
     */
    public function saveConnexion($email)
    {
        $this->httpResponse->setCookie('auth', true);
        $this->httpResponse->setCookie('email', $email);
    }

    /**
     * Unset a connexion session and a connexion cookie
     * 
     * @return void
     */
    public function unsetConnexion()
    {
        session_destroy();

        $this->httpResponse->setCookie('isAuth', false);
        $this->httpResponse->setCookie('authRole', '');
        $this->httpResponse->setCookie('authEmail', '');
    }
}

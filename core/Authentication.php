<?php
namespace Core;

session_start();

class Authentication extends ApplicationComponent
{
    protected $httpRequest;
    protected $httpResponse;
    protected $managers;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->httpRequest = $app->getHttpRequest();
        $this->httpResponse = $app->getHttpResponse();
        $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    }

    /**
     * Check if a user is signed in
     *
     * @return bool
     */
    public function isSignedIn()
    {
        if ($this->httpRequest->getSession('auth')
            && $this->httpRequest->getSession('id') !== null
            && $this->httpRequest->getSession('email') !== null
        ) {
            return true;
        }
        if ($this->httpRequest->getCookie('auth')
            && $this->httpRequest->getCookie('id')
            && $this->httpRequest->getCookie('email')
        ) {
            $this->httpResponse->setSession('auth', true);
            $this->httpResponse->setSession(
                'id',
                $this->httpRequest->getCookie('id')
            );
            $this->httpResponse->setSession(
                'email',
                $this->httpRequest->getCookie('email')
            );

            return true;
        }

        return false;
    }

    /**
     * Check if a user is administrator
     * 
     * @return bool
     */
    public function isAdmin()
    {
        $userManager = $this->managers->getManagerOf('User');

        $user = $userManager->get($this->getEmail());

        if ($user->getRole() !== 'administrator') {
            return true;
        }

        return false;
    }

    /**
     * Get the session user ID
     *
     * @return mixed
     */
    public function getId()
    {
        if ($this->httpRequest->getSession('auth')
            && $this->httpRequest->getSession('id') !== null
            && $this->httpRequest->getSession('email') !== null
        ) {
            return $this->httpRequest->getSession('id');
        }
    }

    /**
     * Get the session user email
     *
     * @return mixed
     */
    public function getEmail()
    {
        if ($this->httpRequest->getSession('auth')
            && $this->httpRequest->getSession('id') !== null
            && $this->httpRequest->getSession('email') !== null
        ) {
            return $this->httpRequest->getSession('email');
        }
    }

    /**
     * Set a connexion session
     *
     * @param int    $id    ID to set in the session
     * @param string $email Email address to set in the session
     *
     * @return void
     */
    public function setConnexion($id, $email)
    {
        $this->httpResponse->setSession('auth', true);
        $this->httpResponse->setSession('id', $id);
        $this->httpResponse->setSession('email', $email);
    }

    /**
     * Set a connexion cookie
     *
     * @param int    $id    ID to save in the cookie
     * @param string $email Email address to save in the cookie
     *
     * @return void
     */
    public function saveConnexion($id, $email)
    {
        $this->httpResponse->setCookie('auth', true);
        $this->httpResponse->setCookie('id', $id);
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
        $this->httpResponse->setCookie('id', '');
        $this->httpResponse->setCookie('email', '');
    }
}

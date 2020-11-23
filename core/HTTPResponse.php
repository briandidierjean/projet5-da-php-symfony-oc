<?php
namespace Core;

class HTTPResponse extends ApplicationComponent
{
    /**
     * Set a header to be sent
     *
     * @param string $header Header to be sent
     *
     * @return void
     */
    public function setHeader($header)
    {
        header($header);
    }

    /**
     * Make a redirection
     *
     * @param string $location Location to be redirected
     *
     * @return void
     */
    public function redirect($location)
    {
        header('Location: '.$location);
        exit();
    }

    /**
     * Redirect to a 401 error page
     * 
     * @return void
     */
    public function redirect401()
    {
        $page = $this->app->twig->render('errors/401.html.twig');

        $this->setHeader('HTTP/1.1 401 Unauthorized ');

        $this->send($page);
    }

    /**
     * Redirect to a 404 error page
     * 
     * @return void
     */
    public function redirect404()
    {
        $page = $this->app->twig->render('errors/404.html.twig');

        $this->setHeader('HTTP/1.0 404 Not Found');

        $this->send($page);
    }

    /**
     * Send a HTML page
     * 
     * @param string $page HTML page to be sent
     *
     * @return void
     */
    public function send($page)
    {
        echo $page;
    }

    /**
     * Set a session variable
     * 
     * @param string $key   Session key to be set
     * @param mixed  $value Session value to be set
     * 
     * @return void
     */
    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Set a cookie variable
     *
     * @param string $name     Name of the cookie
     * @param mixed  $value    Value of the cookie
     * @param int    $expire   Expiration timestamp of the cookie
     * @param mixed  $path     Path where the cookie must be saved
     * @param mixed  $domain   The (sub)domain that the cookie is available to.
     * @param bool   $secure   Indicates that the cookie should only be transmitted
     *                         over the HTTPS protocol.
     * @param bool   $httponly When true the cookie will ba made accessible only
     *                         through the HTTP protocol.
     * 
     * @return void
     */
    public function setCookie(
        $name,
        $value,
        $expire = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httponly = true
    ) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}

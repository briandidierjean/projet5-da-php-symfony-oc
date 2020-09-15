<?php
namespace Core;

class HTTPResponse
{
    /**
     * This method set a header to be sent to the client.
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
     * This method redirect the client.
     *
     * @param string $location Location to be redirected
     *
     * @return void
     */
    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }

    /**
     * This method takes a HTML page and sends it the the client.
     * 
     * @param string $page HTML page to be sent
     *
     * @return void
     */
    public function send($page)
    {
        exit($page);
    }

    /**
     * This method set a secure cookie.
     *
     * @param string $name     Name of the cookie
     * @param string $value    Value of the cookie
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
        $value = '',
        $expire = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httponly = true
    ) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}

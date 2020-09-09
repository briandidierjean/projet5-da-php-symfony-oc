<?php
namespace Core;

/**
 * This class represent a http response.
 */
class HTTPResponse
{
    protected $page;

    /**
     * This method set a header to be sent to the client.
     *
     * @param string $header Header to be sent
     *
     * @return null
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
     * @return null
     */
    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }

    /**
     * This method send the generated page to the client.
     *
     * @return null
     */
    public function send()
    {
        exit($this->page->getGeneratedPage());
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
     * @return null
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

    /**
     * This method sets the page attribute.
     * 
     * @param Page $page Page to be set.
     * 
     * @return null
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }
}

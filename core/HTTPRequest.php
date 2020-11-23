<?php
namespace Core;

class HTTPRequest extends ApplicationComponent
{
    /**
     * Return the URL used
     * 
     * @return mixed
     */
    public function getURL()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Return the method used
     * 
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return a GET variable
     * 
     * @param string $key GET key
     * 
     * @return mixed
     */
    public function getGet($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * Return a POST variable
     * 
     * @param string $key POST key
     * 
     * @return mixed
     */
    public function getPost($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Return a SESSION variable
     * 
     * @param string $key SESSION key
     * 
     * @return string
     */
    public function getSession($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Return a COOKIE variable
     * 
     * @param string $key COOKIE key
     * 
     * @return string
     */
    public function getCookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
}

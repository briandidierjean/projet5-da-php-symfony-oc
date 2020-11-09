<?php
namespace Core;

class HTTPRequest extends ApplicationComponent
{
    /**
     * Return the URL used
     * 
     * @return string
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
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            return $_GET[$key];
        }
        return null;
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
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return null;
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

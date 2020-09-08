<?php
namespace Core;

/**
 * This class represent a http request.
 */
class HTTPRequest
{
    /**
     * This method return the URL used by the client.
     * 
     * @return string
     */
    public function getURL()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * This method return the method used by the client.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * This method checks if a GET key exists.
     * 
     * @param string $key GET key
     * 
     * @return bool
     */
    public function getExists($key)
    {
        return isset($_GET[$key]);
    }

    /**
     * This method returns a GET key value.
     * 
     * @param string $key GET key
     * 
     * @return string
     */
    public function getGet($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
     * This method checks if a POST key exists.
     * 
     * @param string $key POST key
     * 
     * @return bool
     */
    public function postExists($key)
    {
        return isset($_POST[$key]);
    }

    /**
     * This method returns a POST key value.
     * 
     * @param string $key POST key
     * 
     * @return string
     */
    public function getPost($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * This method checks if a COOKIE key exists.
     * 
     * @param string $key COOKIE key
     * 
     * @return bool
     */
    public function cookieExists($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * This method returns a COOKIE key value.
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

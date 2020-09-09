<?php
namespace Core;

abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest;
        $this->httpResponse = new HTTPResponse;
        $this->name = '';
    }

    abstract public function run();

    /**
     * This method returns the httpRequest attribute.
     * 
     * @return HTTPRequest
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * This method returns the httpResponse attribute.
     * 
     * @return HTTPResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * This method returns the name attribute.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
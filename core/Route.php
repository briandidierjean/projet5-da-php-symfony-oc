<?php
namespace Core;

class Route
{
    protected $url;
    protected $controller;
    protected $action;
    protected $vars = [];
    protected $varsNames;

    public function __construct($url, $controller, $action, array $varsNames)
    {
        $this->setURL($url);
        $this->setController($controller);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
    }

    /**
     * Check if a route has variables
     *
     * @return bool
     */
    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    /**
     * Check if a URL has a matching route
     * 
     * @param string $url URL to be matched
     * 
     * @return mixed
     */
    public function match($url)
    {
        if (preg_match('#^'.$this->url.'$#', $url, $matches)) {
            return $matches;
        }
        return false;
    }

    // GETTERS
    public function getUrl()
    {
        return $this->url;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getVarsNames()
    {
        return $this->varsNames;
    }

    // SETTERS
    public function setUrl($url)
    {
        if (is_string($url)) {
            $this->url = $url;
        }
    }
    
    public function setController($controller)
    {
        if (is_string($controller)) {
            $this->controller = $controller;
        }
    }

    public function setAction($action)
    {
        if (is_string($action)) {
            $this->action = $action;
        }
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
    }
}

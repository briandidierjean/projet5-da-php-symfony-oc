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
        $this->setcontroller($controller);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
    }

    /**
     * This method checks if a route has variables.
     *
     * @return bool
     */
    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    public function match($url)
    {
        if (preg_match('#^'.$this->url.'$#', $url, $matches)) {
            return $matches;
        }
        return false;
    }

    /**
     * This method return the URL attribute.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * This method return the controller attribute.
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * This method return the action attribute.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * This method return the vars attribute.
     *
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * This method return the varsNames attribute.
     *
     * @return array
     */
    public function getVarsNames()
    {
        return $this->varsNames;
    }

    /**
     * This method set the URL attribute.
     *
     * @param string $url The URL to be set
     *
     * @return void
     */
    public function setUrl($url)
    {
        if (is_string($url)) {
            $this->url = $url;
        }
    }
    
    /**
     * This method set the controller attribute.
     *
     * @param string $controller The controller to be set
     *
     * @return void
     */
    public function setController($controller)
    {
        if (is_string($controller)) {
            $this->controller = $controller;
        }
    }

    /**
     * This method set the action attribute.
     *
     * @param string $action The action to be set
     *
     * @return void
     */
    public function setAction($action)
    {
        if (is_string($action)) {
            $this->action = $action;
        }
    }

    /**
     * This method set the vars attribute.
     *
     * @param array $vars The vars attribute to be set
     *
     * @return void
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * This method set the varsNames attribute.
     *
     * @param array $varsNames The varsNames attribute to be set
     *
     * @return void
     */
    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
    }
}

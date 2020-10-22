<?php
namespace Core;

class Route
{
    protected $url;
    protected $controller;
    protected $action;
    protected $vars = [];
    protected $varsNames;

    public function __construct(
        $url,
        $controller,
        $action,
        array $varsNames
    ) {
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->varsNames = $varsNames;
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
    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }
}

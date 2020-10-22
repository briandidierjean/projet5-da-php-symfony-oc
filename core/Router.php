<?php
namespace Core;

class Router
{
    public $routes = [];

    /**
     * Add a route to the routes list
     *
     * @param Route $route Route to be added to the list
     *
     * @return void
     */
    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }

    /**
     * Return a route matching a URL
     * 
     * @param string $url URL to be matched
     * 
     * @return Route
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route) {
            if (($varsValues = $route->match($url)) !== false) {
                if ($route->hasVars()) {
                    $varsNames = $route->getVarsNames();
                    $vars = [];

                    foreach ($varsValues as $key => $value) {
                        // The first key contains the entire string.
                        if ($key !== 0) {
                            $vars[$varsNames[$key - 1]] = $value;
                        }
                    }

                    $route->setVars($vars);
                }
                return $route;
            }
        }

        throw new \Exception;
    }
}
